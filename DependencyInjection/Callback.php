<?
namespace pfc\DependencyInjection;


use \ReflectionMethod;


class Callback{
	private $_classname;
	private $_classmethod;

	private $_factory;


	const   SEPARATOR = "::";


	function __construct($classmethod, ClassFactory $factory = null){
		if (! is_array($classmethod))
			$classmethod = explode(self::SEPARATOR, $classmethod);

		if (! $factory)
			$factory = new AutoClassFactory();

		$this->_classname	= $classmethod[0];
		$this->_classmethod	= $classmethod[1];
		$this->_factory		= $factory;
	}


	function exec(Dependency $dependency){
		$args = array();

		$instance = $this->_factory->getInstance($this->_classname);

		$requirements = self::getDependencyRequirements($instance, $this->_classmethod);

		foreach($requirements as $dep)
			$args[$dep] = $dependency[$dep];

		return call_user_func_array( array($instance, $this->_classmethod), $args);
	}


	private static function getDependencyRequirements($classname, $classmethod){
		$reflection = new ReflectionMethod($classname, $classmethod);

		$params = array();

		foreach($reflection->getParameters() as $param)
			$params[] = $param->name;

		return $params;
	}
}


