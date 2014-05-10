<?
namespace pfc\Framework;

use pfc\Loggable;

/**
 * Registry
 *
 */
class Registry implements \ArrayAccess {
	use Loggable;
	
	const   SEPARATOR = "/";
	
	private $_data = array();

	private $_path;
	private $_ext;

	
	function __construct($path, $ext = ".php"){
		$this->_path = self::checkPath($path);
		$this->_ext  = $ext;
	}
	
	
	private static function checkPath($path){
		if ($path == "")
			$path = ".";
		
		if (substr($path, -1) != self::SEPARATOR)
			$path .= self::SEPARATOR;
			
		return $path;
	}
	
	
	private function getFileName($item){
		return $this->_path . $item . $this->_ext;
	}


	private function loadItem($item){
		$filename = $this->getFileName($item);
		
		if (file_exists($filename)){
			$this->logDebug("loading $filename");
			return include $filename;
		}
		
		$this->logDebug("loading $filename failed");
		
		return null;
	}


	/* Magic functions */

	function offsetSet($offset, $value) {
		if (is_null($offset))
			return;

		$this->_data[$offset] = $value;
	}


	function offsetExists($offset) {
		return isset($this->_data[$offset]);
	}


	function offsetUnset($offset) {
		unset($this->_data[$offset]);
	}


	function offsetGet($offset) {
		if (isset($this->_data[$offset]))
			return $this->_data[$offset];

		$value = $this->loadItem($offset);
		
		if ($value !== null){
			$this->_data[$offset] = $value;
			return $value;
		}
		
		return null;
	}


	/* tests */

	static function test(){
		$logger = new \pfc\Logger();
		$logger->addOutput(new \pfc\OutputAdapter\Console());


		$registry = new Registry(__DIR__ . "/../data/registry/");
		$registry->setLogger($logger);
		
		
		assert($registry["test"] == "test");
		assert($registry["array"][0] == "test");
		
		$cl = $registry["class"];
		assert($cl->test == "test");
		
		print_r($registry["bla"]);
	}
}


