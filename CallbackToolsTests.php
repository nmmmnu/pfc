<?
namespace pfc;

class CallbackToolsTests{
	function bla($name, $age){
		return sprintf("%s is %d years old", $name, $age);
	}

	static function test(){
		$func   = "pfc\CallbackToolsTests::bla";
		$params = array("age" => 33, "name" => "Niki");

		$s = CallbackTools::execMethod($func, $params);

		assert($s == "Niki is 33 years old");
	}
}


