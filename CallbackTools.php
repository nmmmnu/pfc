<?
namespace pfc;

class CallbackTools{
	static function getArguments($class_method, array $params){
		$refm = new \ReflectionMethod($class_method);

		$args = array();
		foreach ($refm->getParameters() as $param)
			$args[] = $params[ $param->name ];

		return $args;
	}


	static function execMethod($class_method, array $params){
		$args = self::getArguments($class_method, $params);

		list($classname, $classmethod) = explode("::", $class_method);

		$instance = new $classname;

		return call_user_func_array( array($instance, $classmethod), $args);
	}
}


