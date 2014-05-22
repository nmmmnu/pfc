<?
namespace pfc\DependencyInjection;


use \ReflectionClass;
use \ReflectionMethod;


class Callback{
	private $_classname;
	private $_classmethod;

	private $_dependency;
	private $_factory;


	const   SEPARATOR = "::";


	function __construct($classmethod, ClassFactory $factory = null, Dependency $dependency = null){
		if (! is_array($classmethod))
			$classmethod = explode(self::SEPARATOR, $classmethod);

		if (! $factory)
			$factory = new AutoClassFactory();

		$this->_classname	= $classmethod[0];
		$this->_classmethod	= $classmethod[1];
		$this->_factory		= $factory;
		$this->_dependency	= $dependency;
	}


	function exec(Dependency $dependency = null){
		$container = new Dependency();

		if ($this->_dependency)
			$container->addParent($this->_dependency);

		if ($dependency)
			$container->addParent($dependency);

		$args = array();

		$instance = $this->_factory->getInstance($this->_classname);

		$requirements = self::getDependencyRequirements($instance, $this->_classmethod);

		foreach($requirements as $dep)
			$args[$dep] = $container[$dep];

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


