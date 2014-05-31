<?
namespace pfc\Framework;


/**
 * class for genarating link URLs from the Router
 * made for ecapsulation
 */
final class LinkRouter{
	private $_router;


	/**
	 * constructor
	 *
	 * @param Router $router
	 */
	function __construct(Router $router){
		$this->_router = $router;
	}


	/**
	 * get the link URL from the Router
	 *
	 * @param string $key router key
	 * @param array $params
	 */
	function link($key, array $params = array()){
		return $this->_router->link($key, $params);
	}


	/**
	 * allow class to be called as function $_link_router("/");
	 *
	 * @param string $key router key
	 * @param array $params
	 */
	function __invoke($key, array $params = array()){
		return $this->link($key, $params);
	}
}


