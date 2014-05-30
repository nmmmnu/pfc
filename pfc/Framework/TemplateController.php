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
	private $_params2 = array();
	private $_code;


	/**
	 * constructor
	 *
	 * @param string $filename template file
	 * @param array $params additional params
	 * @param boolean $error produce output with code 500 (HTTP/1.0 500 Internal Error)
	 *
	 */
	function __construct($filename, array $params = array(), $code = 0){
		$this->_filename	= $filename;
		$this->_params		= $params;
		$this->_code		= $code;
	}


	function setRouting($path, array $args){
		$this->_params2  = $args;
	}


	function process(){
		return new Response\Template($this->_filename, $this->_params + $this->_params2, $this->_code);
	}
}

