<?
namespace pfc\UnitTests;


use pfc\DependencyInjection\Callback;
use pfc\DependencyInjection\Dependency;

use pfc\DependencyInjection\ClassFactory,
	pfc\DependencyInjection\AutoClassFactory,
	pfc\DependencyInjection\FileClassFactory;



if (!class_exists(__NAMESPACE__ . "\\" . "DependencyInjectionTests", $autoload = false)){
class DependencyInjectionTests{
	function bla($name, $age){
		return sprintf("%s is %d years old", $name, $age);
	}

	function bla2($name, $age){
		return uniqid();
	}

	static function test(){
		// params test

		$func = "DependencyInjectionTests::bla";

		$deps = new Dependency();
		$deps->addParent(array("age" => 33, "name" => "Niki"));

		self::testCallback($func, $deps, new AutoClassFactory(__NAMESPACE__));
		self::testCallback($func, $deps, new FileClassFactory(__DIR__));
	}


	static function testCallback($func, Dependency $deps, ClassFactory $factory){
		$callback = new Callback($func, $factory);
		$s = $callback->exec($deps);

		assert($s == "Niki is 33 years old");
	}
}
} // class_exists


return new DependencyInjectionTests();
