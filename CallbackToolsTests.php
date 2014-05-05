<?
namespace pfc;

class CallbackToolsTests{
	function bla($name, $age){
		return sprintf("%s is %d years old", $name, $age);
	}

	static function test(){
		$func   = "pfc\CallbackToolsTests::bla";
		$params = array("age" => 33, "name" => "Niki");

		$x = new CallbackToolsTests();

		$s = call_user_func_array(array($x, "bla"), CallbackTools::getArguments($func, $params) );

		assert($s == "Niki is 33 years old");
	}
}


