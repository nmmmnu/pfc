<?
namespace pfc\UnitTests;

use pfc\Callback;
use pfc\ArrayList;

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


		/*
		// memoize test

		$func   = __CLASS__ . "::bla2";
		$params = array();

		$cos = new ArrayList();

		$callback = new Callback($func, $params);
		$r1 = $callback->execMemoized("uid", $cos);
		$r2 = $callback->execMemoized("uid", $cos);

		assert($r1 == $r2);
		*/


		// same object test
		$cos = new ArrayList();

		$callback1 = new Callback($func, $params, $cos);
		$callback2 = new Callback($func, $params, $cos);

		assert($callback1->getInstance(true) === $callback2->getInstance(true));
	}
}


