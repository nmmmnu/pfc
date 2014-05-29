<?
namespace pfc\Framework;


use \pfc\Template;


/**
 * Controller that process Template
 *
 */
class TemplateController implements AbstractController{
	private $_filename;
	private $_params;
	private $_params2;


	/**
	 * constructor
	 *
	 * @param string $filename template file
	 * @param array $params additional params
	 *
	 */
	function __construct($filename, array $params = array()){
		$this->_filename = $filename;
		$this->_params   = $params;
	}


	function setRouting($path, array $args){
		$this->_params2  = $args;
	}


	function process(){
		return new Response\Template($this->_filename, $this->_params + $this->_params2);
	}
}

