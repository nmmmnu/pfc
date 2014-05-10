<?
namespace pfc\Framework\Route;

use pfc\Framework\Route;

class Exact implements Route{
	private $_path;


	function __construct($path){
		if (strlen($path) == 0)
			$path = self::HOMEPATH;

		$this->_path = $path;
	}


	function link(array $params){
		return $this->_path;
	}


	function match($path){
		if ($this->_path != $path)
			return false;

		return array();
	}


	static function test(){
		$r = new Exact("/index.php");

		assert( $r->match("/index.php") !== false);
		assert( $r->match("/bla.php") === false );
	}
}

