<?
namespace pfc;


use \ReflectionMethod;


class Callback{
	private $_classname;
	private $_classmethod;

	private $_factory;
	private $_providers;


	const   SEPARATOR = "::";


	function __construct($classmethod, ClassFactory $factory, ArrayList $_providers = null){
		if (! is_array($classmethod))
			$classmethod = explode(self::SEPARATOR, $classmethod);

		$this->_classname	= $classmethod[0];
		$this->_classmethod	= $classmethod[1];
		$this->_factory		= $factory;
		$this->_providers	= $_providers;
	}


	function exec(ArrayList $extraProviders = null){
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


	function getDependency($dependency, ArrayList $extraProviders = null) {
		if ($this->_providers)
			foreach($this->_providers as $dep){
				$value = $dep->get($dependency);

				if ($value)
					return $value;
			}

		// do same for the $extraProviders

		if ($extraProviders)
			foreach($extraProviders as $dep){
				$value = $dep->get($dependency);

				if ($value)
					return $value;
			}

		return null;
	}
}


