<?
namespace pfc;


use \ReflectionMethod;


class Callback{
	private $_classname;
	private $_classmethod;

	private $_factory;
	private $_mainProviders;


	const   SEPARATOR = "::";


	function __construct($classmethod, ClassFactory $factory, array $mainProviders = array()){
		if (! is_array($classmethod))
			$classmethod = explode(self::SEPARATOR, $classmethod);

		$this->_classname	= $classmethod[0];
		$this->_classmethod	= $classmethod[1];
		$this->_factory		= $factory;
		$this->_mainProviders	= $mainProviders;
	}


	function exec(array $extraProviders = array()){
		$args = array();

		foreach($this->getDependencyRequirements() as $dep)
			$args[$dep] = $this->getDependency($dep, $extraProviders);

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


	function getDependency($dependency, array $extraProviders) {
		$allProviders = array_merge($this->_mainProviders, $extraProviders);

		foreach($allProviders as $dep){
			$value = $dep->get($dependency);

			if ($value)
				return $value;
		}


		return null;
	}
}


