<?
namespace pfc\Framework\Route;

use pfc\Framework\Route;

class Exact implements Route{
	private $_path;
	private $_controller;


	function __construct($path, $controller){
		if (strlen($path) == 0)
			$path = self::HOMEPATH;

		$this->_path = $path;
		$this->_controller = $controller;
	}


	function link(array $params){
		return $this->_path;
	}


	function match($path){
		if ($this->_path != $path)
			return false;

		return array($this->_controller, array());
	}


	static function test(){
		$r = new Exact("/index.php", "bla");

		assert( $r->match("/index.php") != null);
		assert( $r->match("/bla.php") == null );
	}
}

