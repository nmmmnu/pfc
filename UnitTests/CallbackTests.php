<?
namespace pfc\UnitTests;

use pfc\Callback;

class CallbackTests{
	function bla($name, $age){
		return sprintf("%s is %d years old", $name, $age);
	}

	static function test(){
		$func   = __CLASS__ . "::bla";
		$params = array("age" => 33, "name" => "Niki");

		$callback = new Callback($func, $params);

		$s = $callback->exec();

		assert($s == "Niki is 33 years old");
	}
}


