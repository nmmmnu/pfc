<?
namespace pfc;


/**
 * Resources
 *
 * map Callback's to keys,
 * then access those using the keys.
 *
 */
class CallbackCollection{
	private $_data = array();
	private $_memoized;


	function __construct($memoized = false){
		$this->_memoized = $memoized;
	}


	/**
	 * map Callback to some key
	 * @param string $key
	 * @param string $controller method to be executed
	 * @param array $params parameters/arguments for the controller
	 *
	 */
	function map($key, Callback $callback){
		$this->_data[$key] = $callback;
	}


	/**
	 * exec Callback.
	 *
	 * controller is instanciated and method is called.
	 *
	 * @param string $key
	 * @return mixed|null
	 *
	 */
	function exec($key){
		if (!isset($this->_data[$key]))
			return null;

		$callback = $this->_data[$key];

		if ($this->_memoized)
			return $callback->exec($key);

		return $callback->exec();
	}


	/**
	 * get the Callback
	 *
	 * @param string $key
	 * @return mixed|null
	 *
	 */
	function get($key){
		if (!isset($this->_data[$key]))
			return null;

		return $this->_data[$key];
	}
}

