<?
namespace pfc\Framework\Controller;


use \pfc\Framework\Response\Template as Response_Template;


/**
 * Controller that process Template
 *
 */
class Template implements Controller{
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
		return new Response_Template($this->_filename, $this->_params + $this->_params2, $this->_code);
	}
}

