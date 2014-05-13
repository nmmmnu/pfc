<?
namespace pfc;

/**
 * CallbackFactory
 *
 * Responsibilities
 * - Easy creating Callbacks that uses this same factory.
 * - Create Objects for use with Callback, but create them only once.
 *
 */
class CallbackFactory implements \Countable{
	private $_objectStorage = array();
	private $_additional_params;
	private $_loader;


	function __construct(array $additional_params = array(), Loader $loader = null){
		$this->_loader            = $loader;
		$this->_additional_params = $additional_params;
	}


	/**
	 * Create new Callback
	 *
	 * @param string $classname
	 * @param array $params
	 * @return Callback
	 *
	 */
	function getCallback($classname, array $params = array()){
		$callback = new Callback($classname, $this->_additional_params, $this);
		$callback->setParams($params, $merge = true);

		return $callback;
	}


	/**
	 * Create new Object to be used with Callback
	 *
	 * @param string $classname
	 * @return Object
	 *
	 */
	function getObject($classname){
		if (isset($this->_objectStorage[$classname]))
			return $this->_objectStorage[$classname];

		//var_dump($this);
	
		$instance = $this->classLoader($classname);

		$this->_objectStorage[$classname] = $instance;

		return $instance;
	}


	function count(){
		return count($this->_objectStorage);
	}
	
	
	private function classLoader($classname){
		if ($this->_loader){
			$instance = $this->_loader->getInstance($classname);
			
			return is_object($instance) ? $instance : null;
		}
		
		return new $classname;
	}
}
