<?
namespace pfc\UnitTests;

use pfc\Callback;
use pfc\CallbackM;

class CallbackTests{
	function bla($name, $age){
		return sprintf("%s is %d years old", $name, $age);
	}

	function bla2($name, $age){
		return uniqid();
	}

	static function test(){
		$func   = __CLASS__ . "::bla";
		$params = array("age" => 33, "name" => "Niki");

		$callback = new Callback($func, $params);
		$s = $callback->exec();

		assert($s == "Niki is 33 years old");

		// memoize test

		$func   = __CLASS__ . "::bla2";
		$params = array();

		$callback = new Callback($func, $params);
		$r1 = $callback->exec("uid");
		$r2 = $callback->exec("uid");

		assert($r1 == $r2);
	}
}


