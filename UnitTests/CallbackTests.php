<?
namespace pfc\UnitTests;


use pfc\Callback;
use pfc\ClassFactory;
use pfc\DependencyProvider;
use pfc\Loader;


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

		$deps1 = array(
			new DependencyProvider(new Loader\ArrayLoader(array("name" => "Niki")))
		);

		$deps2 = array(
			new DependencyProvider(new Loader\ArrayLoader(array("age" => 33)))
		);

		$factory = new ClassFactory();

		$callback = new Callback($func, $factory, $deps1);
		$s = $callback->exec($deps2);

		assert($s == "Niki is 33 years old");
	}
}


