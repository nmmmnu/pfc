<?
namespace pfc\Framework;


use \pfc\Template;


/**
 * Controller that process HTTP redirect
 *
 */
class RedirectController implements AbstractController{
	private $_location;


	/**
	 * constructor
	 *
	 * @param string $location HTTP redirect location
	 *
	 */
	function __construct($location){
		$this->_location = $location;
	}


	function setRouting($path, array $args){
		// no need to do anything
	}


	function process(){
		return new Response\Redirect($this->_location);
	}
}

