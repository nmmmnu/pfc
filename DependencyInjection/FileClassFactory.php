<?
namespace pfc\DependencyInjection;


class FileClassFactory extends ClassFactory{
	const   SEPARATOR = "/";
	const   EXTENTION = ".php";


	private $_path;
	private $_ext;


	function __construct($path, $ext = self::EXTENTION){
		$this->_path = self::checkPath($path);
		$this->_ext  = $ext;
	}


	protected function classLoader($classname){
		$file = $this->getFileName($classname);

		if (file_exists($file)){
			$instance = include $file;

			if (is_object($instance))
				return $instance;
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


	protected function getFileName($classname){
		return $this->_path . $classname . $this->_ext;
	}
}
