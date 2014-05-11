<?
namespace pfc;

use \ReflectionMethod;

class Callback{
	private $_classmethod;
	private $_params;
	private $_instance;

	private $_memoized = array();


	const   SEPARATOR = "::";


	function __construct($classmethod, array $params = array(), $instance = null){
		$this->_classmethod = $classmethod;
		$this->_params      = $params;
		$this->_instance    = $instance;
	}


	function setParams($params){
		$this->_params      = $params;
	}


	function setInstance($instance){
		$this->_instance    = $instance;
	}


	function exec($memoizedID = false){
		if (!$memoizedID)
			return $this->exec2();

		if (isset($this->_memoized[$memoizedID]))
			return $this->_memoized[$memoizedID];

		$this->_memoized[$memoizedID] = $this->exec2();

		return $this->_memoized[$memoizedID];
	}


	private function exec2(){
		$args = $this->getArguments();

		list($classname, $classmethod) = explode(self::SEPARATOR, $this->_classmethod);

		if ($this->_instance == null){
			// This can be done in the constructor,
			// but here is much better,
			// because class is instantiated only if needed.
			$this->_instance = new $classname;
		}

		return call_user_func_array( array($this->_instance, $classmethod), $args);
	}


	private function getArguments(){
		$refm = new ReflectionMethod($this->_classmethod);

		$args = array();
		foreach ($refm->getParameters() as $param)
			$args[] = $this->getParam($param->name);

		return $args;
	}


	private function getParam($name, $default = null){
		if ( isset( $this->_params[$name] ))
			return $this->_params[$name];

		return $default;
	}
}

