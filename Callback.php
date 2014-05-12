<?
namespace pfc;

use \ReflectionMethod;

class Callback{
	private $_classname;
	private $_classmethod;
	private $_instance = null;

	private $_objectStorage;

	private $_params;

	private $_memoized = array();


	const   SEPARATOR = "::";


	/**
	 * constructor
	 *
	 * @param callable $classmethod
	 * @param array $params
	 *
	 */
	function __construct($classmethod, array $params = array(), \ArrayAccess $objectStorage = null){
		if (! is_array($classmethod))
			$classmethod = explode(self::SEPARATOR, $classmethod);

		$this->_classname     = $classmethod[0];
		$this->_classmethod   = $classmethod[1];
		$this->_params        = $params;
		$this->_objectStorage = $objectStorage;
	}


	/**
	 * set parameters
	 *
	 * @param array $params
	 *
	 */
	function setParams($params){
		$this->_params      = $params;
	}


	/**
	 * get underline instance
	 *
	 * used mostly for testing
	 *
	 * @param boolean $instantiate whatever to create the class, if not created yet
	 * @return object
	 */
	function getInstance($instantiate = true){
		if ($this->_instance == null){
			if ($instantiate == false)
				return null;

			$this->_instance = $this->createInstance();
		}

		return $this->_instance;
	}


	private function createInstance(){
		$classname = $this->_classname;

		if ($this->_objectStorage){
			$instance = $this->_objectStorage[$classname];
			if ($instance)
				return $instance;
		}

		$instance = new $classname;

		if ($this->_objectStorage)
			$this->_objectStorage[$classname] = $instance;

		return $instance;
	}


	/**
	 * exec the callback
	 *
	 * @param boolean $memoizedID if present, the result will be stored internally
	 * @return mixed
	 */
	function exec($memoizedID = false){
		if (!$memoizedID)
			return $this->exec2();

		if (isset($this->_memoized[$memoizedID]))
			return $this->_memoized[$memoizedID];

		$this->_memoized[$memoizedID] = $this->exec2();

		return $this->_memoized[$memoizedID];
	}


	private function exec2(){
		$instance = $this->getInstance();
		$method   = $this->_classmethod;
		$args     = $this->getArguments();

		return call_user_func_array( array($instance, $this->_classmethod), $args);
	}


	private function getArguments(){
		$refm = new ReflectionMethod($this->_classname, $this->_classmethod);

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

