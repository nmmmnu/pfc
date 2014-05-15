<?
namespace pfc\DependencyInjection;


use \ReflectionMethod;
use \pfc\ClassFactory;


class Callback{
	private $_classname;
	private $_classmethod;

	private $_factory;


	const   SEPARATOR = "::";


	function __construct($classmethod, ClassFactory $factory = null){
		if (! is_array($classmethod))
			$classmethod = explode(self::SEPARATOR, $classmethod);

		if (! $factory)
			$factory = new ClassFactory();

		$this->_classname	= $classmethod[0];
		$this->_classmethod	= $classmethod[1];
		$this->_factory		= $factory;
	}


	function exec(Dependency $dependency){
		$args = array();

		foreach($this->getDependencyRequirements() as $dep)
			$args[$dep] = $dependency[$dep];

		$instance = $this->_factory->getInstance($this->_classname);

		return call_user_func_array( array($instance, $this->_classmethod), $args);
	}


	private function getDependencyRequirements(){
		$reflection = new ReflectionMethod($this->_classname, $this->_classmethod);

		$params = array();

		foreach($reflection->getParameters() as $param)
			$params[] = $param->name;

		return $params;
	}
}


