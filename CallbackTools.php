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
}


