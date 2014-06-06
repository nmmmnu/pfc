<?
namespace pfc\Framework\Controller;


use \pfc\Framework\Response\Redirect as Response_Redirect;


/**
 * Controller that process HTTP redirect
 *
 */
class Redirect implements Controller{
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
		return new Response_Redirect($this->_location);
	}
}

