<?
namespace pfc\Framework;

use pfc\CallbackTools;

class Router{
	private $_data = array();

	private $_lastResult;
	private $_prefix;


	function __construct($prefix = ""){
		$this->_prefix = $prefix;
	}


	function map($name, Route $route){
		$this->_data[$name] = $route;
	}


	function link($name, array $params){
		return $this->_data[$name]->link($params);
	}


	function processRequest($path){
		foreach($this->_data as $r){
			$result = $r->match($path);

			if (is_array($result)){
				list($class_method, $params) = $result;

				$class_method = $this->_prefix . $class_method;

				$this->_lastResult = CallbackTools::execMethod($class_method, $params);

				return true;
			}
		}

		return false;
	}


	function getLastResult(){
		return $this->_lastResult;
	}
}

