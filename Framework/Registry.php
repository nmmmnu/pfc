<?
namespace pfc\Framework;

use pfc\Loggable;

/**
 * Registry
 *
 */
class Registry implements \ArrayAccess {
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

		if (file_exists($filename))
			return include $filename;

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
		$registry = new Registry(__DIR__ . "/../data/config");


		assert($registry["test"] == "test");
		assert($registry["array"][0] == "test");
	}
}


