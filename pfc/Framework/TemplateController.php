<?
namespace pfc\Framework;


use \pfc\Template;


class TemplateController implements AbstractController{
	private $_filename;
	private $_params;
	private $_params2;


	function __construct($filename, $params = array()){
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

