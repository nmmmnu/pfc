<?
namespace pfc\Framework;

class Controller{
	private $_registry  = null;
	private $_resources = null;


	function setRegistry(Registry $registry){
		$this->_registry = $registry;
	}


	function setResources(Registry $resources){
		$this->_resources = $resources;
	}


	protected function getRegistry(){
		return $this->_registry;
	}


	protected function getResources(){
		return $this->_resources;
	}



}

