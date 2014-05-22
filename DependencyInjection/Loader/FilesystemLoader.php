<?
namespace pfc\DependencyInjection\Loader;


use pfc\DependencyInjection\Loader;


/**
 * Abstract Loader that loads data from file
 *
 */
abstract class FilesystemLoader implements Loader{
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

