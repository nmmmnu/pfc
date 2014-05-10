<?
namespace pfc\Framework;

use pfc\Callback;
use pfc\CallbackCollection;

class Router{
	private $_data = array();


	function __construct(){
	}


	function map($key, Route $route, Callback $callback){
		$this->_data[$key] = array(
			"route"    => $route,
			"callback" => $callback
		);
	}


	function link($key, array $params){
		return $this->_routes[$key]["route"]->link($params);
	}


	function processRequest($path){
		foreach($this->_data as $data){
			$route    = $data["route"];
			$callback = $data["callback"];

			$result = $route->match($path);

			if (is_array($result)){
				$callback->setParams($result);

				return $callback->exec();
			}
		}

		return null;
	}
}

