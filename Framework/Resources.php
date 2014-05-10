<?
namespace pfc\Framework;

use pfc\CallbackTools;

/**
 * Registry
 *
 */
class Resources{
	private $_data = array();

	private $_prefix;


	function __construct($prefix = ""){
		$this->_prefix = $prefix;
	}


	function map($name, $controller, array $params){
		$this->_data[$name] = array($controller, $params);
	}


	function get($name){
		if (!isset($this->_data[$name]))
			return null;

		list($class_method, $params) = $this->_data[$name];

		$class_method = $this->_prefix . $class_method;

		$value = CallbackTools::execMethod($class_method, $params);

		return $value;
	}

}


