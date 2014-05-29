<?
namespace pfc\Framework;


class Router{
	private $_routes = array();


	function map($key, Route $route){
		$this->_routes[$key] = $route;
	}


	function remove($key){
		unset($this->_routes[$key]);
	}


	function link($key, array $params){
		if (isset($this->_routes[$key]))
			return $this->_routes[$key]->link($params);

		return null;
	}


	function processRequest($path){
		foreach($this->_routes as $route){
			$controller = $route->match($path);
			if ($controller)
				return $controller;
		}

		throw new RouterException("None of routes matched");
	}
}

