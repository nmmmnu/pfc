<?
namespace pfc\Framework;


final class LinkRouter{
	private $_router;


	function __construct(Router $router){
		$this->_router = $router;
	}


	function link($key, array $params){
		return $this->_router->link($key, $params);
	}
}


