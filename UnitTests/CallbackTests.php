<?
namespace pfc\UnitTests;

use pfc\Callback;
use pfc\CallbackFactory;


class CallbackTests{
	function bla($name, $age){
		return sprintf("%s is %d years old", $name, $age);
	}

	function bla2($name, $age){
		return uniqid();
	}

	static function test(){
		// params test

		$func   = __CLASS__ . "::bla";
		$params = array("age" => 33, "name" => "Niki");

		$callback = new Callback($func, $params);
		$s = $callback->exec();

		assert($s == "Niki is 33 years old");


		// same object test
		$cos = new CallbackFactory();


		$callback1 = $cos->getCallback($func, $params);
		$callback2 = $cos->getCallback($func, $params);

		assert($callback1->getInstance(true) === $callback2->getInstance(true));
	}
}


