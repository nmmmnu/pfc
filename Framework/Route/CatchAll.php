<?
namespace pfc\Framework\Route;

use pfc\Framework\Route;
use pfc\Framework\Controller;

class CatchAll implements Route{
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
		return array();
	}


	static function test(){
		$r = new CatchAll("/index.php");

		assert( $r->match("/index.php") !== false);
		assert( $r->match("/bla.php") !== false );
	}
}



