<?
namespace pfc\UnitTests;


use pfc\Callback;
use pfc\ClassFactory;
use pfc\ArrayList;
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

		$deps = new ArrayList();
		$deps[] = new DependencyProvider(new Loader\ArrayLoader(array("age" => 33, "name" => "Niki")));

		$factory = new ClassFactory();

		$callback = new Callback($func, $factory);
		$s = $callback->exec($deps);

		assert($s == "Niki is 33 years old");
	}
}


