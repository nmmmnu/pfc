<?
namespace pfc;

use \ReflectionMethod;
use \ArrayAccess;

class Callback{
	private $_classname;
	private $_classmethod;
	private $_instance = null;

	private $_params;

	private $_objectStorage;

	const   SEPARATOR = "::";


	/**
	 * constructor
	 *
	 * @param callable $classmethod
	 * @param array $params
	 *
	 */
	function __construct($classmethod, array $params = array(), ArrayAccess $objectStorage = null){
		if (! is_array($classmethod))
			$classmethod = explode(self::SEPARATOR, $classmethod);

		$this->_classname     = $classmethod[0];
		$this->_classmethod   = $classmethod[1];
		$this->_params        = $params;
		$this->_objectStorage = $objectStorage;
	}


	/**
	 * get parameters
	 *
	 * @return array
	 *
	 */
	function getParams(){
		return $this->_params;
	}


	/**
	 * set parameters
	 *
	 * @param array $params
	 *
	 */
	function setParams($params){
		$this->_params = $params;
	}


	/**
	 * set object storage
	 *
	 * @param array $params
	 *
	 */
	function setObjectStorage(ArrayAccess $objectStorage){
		$this->_objectStorage = $objectStorage;
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


	/**
	 * exec the callback
	 *
	 * @return mixed
	 */
	function exec(){
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
}

