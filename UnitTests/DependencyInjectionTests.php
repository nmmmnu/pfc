<?
namespace pfc\UnitTests;


use pfc\DependencyInjection\Callback;
use pfc\DependencyInjection\Dependency;
use pfc\DependencyInjection\Loader\DILoader;


class DependencyInjectionTests{
	function bla($name, $age){
		return sprintf("%s is %d years old", $name, $age);
	}

	function bla2($name, $age){
		return uniqid();
	}

	static function test(){
		// params test

		$func = __CLASS__ . "::bla";

		$deps = new Dependency();
		$deps->addParent(array("age" => 33, "name" => "Niki"));


		// Test Callback
		$callback = new Callback($func);
		$s = $callback->exec($deps);

		assert($s == "Niki is 33 years old");


		// test Loader\DILoader
		$loader = new DILoader($deps);
		$s = $loader->load($func);

		assert($s == "Niki is 33 years old");
	}
}


