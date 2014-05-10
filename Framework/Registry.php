<?
namespace pfc\Framework;

use pfc\Loggable;

/**
 * Registry
 *
 * Class for organizing relatively simple information,
 * such configuration data.
 *
 * All "keys" and "values" are files stored into the some directory,
 * "keys" are filenames,
 * "values" are content of the files:
 *
 * ...scalars:
 *
 * < ? return "secret"; ? >
 *
 * ...or array:
 *
 * < ?
 * return array(
 *      "host" => "localhost",
 *      "port" => 80
 * );
 * ? >
 *
 * ...or even class:
 *
 * < ?
 * class Bla{
 * }
 *
 * return new Bla();
 * ? >
 *
 * Once retrieved, data is stored in memory.
 *
 * In case of classes, this is equivalent to Singleton pattern.
 *
 * However the Registry is mainly made for scalars and arrays.
 *
 */
class Registry {
	const   SEPARATOR = "/";

	private $_data = array();

	private $_path;
	private $_ext;


	/**
	 * constructor
	 * @param string $path directory where registry files are placed
	 * @param string $ext file extention
	 *
	 */
	function __construct($path, $ext = ".php"){
		$this->_path = self::checkPath($path);
		$this->_ext  = $ext;
	}


	/**
	 * get an item from the Registry
	 * @param string $item
	 * @return mixed|null
	 *
	 */
	function get($key) {
		if (isset($this->_data[$key]))
			return $this->_data[$key];

		$value = $this->loadItemFromFilesystem($key);

		if ($value !== null){
			$this->_data[$key] = $value;
			return $value;
		}

		return null;
	}


	private static function checkPath($path){
		if ($path == "")
			$path = ".";

		if (substr($path, -1) != self::SEPARATOR)
			$path .= self::SEPARATOR;

		return $path;
	}


	private function getFileName($key){
		return $this->_path . $key . $this->_ext;
	}


	private function loadItemFromFilesystem($key){
		$filename = $this->getFileName($key);

		if (file_exists($filename))
			return include $filename;

		return null;
	}


	/* tests */

	static function test(){
		$registry = new Registry(__DIR__ . "/../data/config");

		assert($registry->get("test") == "test");
		assert($registry->get("array")[0] == "test");
	}
}


