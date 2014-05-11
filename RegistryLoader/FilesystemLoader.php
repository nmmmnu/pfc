<?
namespace pfc\RegistryLoader;

use pfc\RegistryLoader;


/**
 * Load data from directory
 *
 */
abstract class FilesystemLoader implements RegistryLoader{
	const   SEPARATOR = "/";

	private $_path;
	private $_ext;


	function __construct($path, $ext){
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


	protected function getFileName($key){
		return $this->_path . $key . $this->_ext;
	}
}

