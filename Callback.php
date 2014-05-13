<?
namespace pfc;

use \ReflectionMethod;

/**
 * Callback
 *
 * execute class/methods represented as string.
 *
 * Responsibilities
 * - Bind the arguments of the method in correct way.
 * - Execute method.
 *
 */
class Callback{
	private $_classname;
	private $_classmethod;
	private $_params;

	private $_factory;


	const   SEPARATOR = "::";


	/**
	 * constructor
	 *
	 * @param callable $classmethod
	 * @param array $params
	 * @param CallbackFactory $factory
	 *
	 */
	function __construct($classmethod, array $params = array(), CallbackFactory $factory = null){
		if (! is_array($classmethod))
			$classmethod = explode(self::SEPARATOR, $classmethod);

		$this->_classname   = $classmethod[0];
		$this->_classmethod = $classmethod[1];
		$this->_params      = $params;

		if ($factory == null)
			$factory = new CallbackFactory();

		$this->_factory     = $factory;
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
	function setParams($params, $merge = false){
		if ($merge == false){
			$this->_params = $params;
			return;
		}

		// merge arrays, the safe way, but with overwrite
		foreach($params as $k => $v)
			$this->_params[$k] = $v;
	}


	/**
	 * set Factory for creating underline objects
	 *
	 * @param array $params
	 *
	 */
	function setCallbackFactory(CallbackFactory $factory){
		$this->_factory = $factory;
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


	/**
	 * get underline instance
	 *
	 * @return object
	 *
	 */
	function getInstance(){
		return $this->_factory->getObject($this->_classname);
	}


	private function getArguments(){
		$refm = new ReflectionMethod($this->_classname, $this->_classmethod);

		$args = array();
		foreach ($refm->getParameters() as $param)
			$args[] = $this->getP($param->name);

		return $args;
	}


	private function getP($name, $default = null){
		if ( isset( $this->_params[$name] ))
			return $this->_params[$name];

		return $default;
	}
}

