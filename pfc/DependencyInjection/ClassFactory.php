<?
namespace pfc\DependencyInjection;


abstract class ClassFactory{
	private $_store = array();


	function getInstance($classname){
		if (isset($this->_store[$classname]))
			return $this->_store[$classname];

		$instance = $this->classLoader($classname);

		$this->_store[$classname] = $instance;

		return $instance;
	}


	abstract protected function classLoader($classname);
}

