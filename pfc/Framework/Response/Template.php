<?
namespace pfc\Framework\Response;


use pfc\Framework\Response;
use pfc\Framework\ControllerException;
use pfc\Template as pfc_Template;


class Template implements Response{
	private $_template;
	private $_filename;
	private $_params;


	function __construct($filename, $params = array()){
		$this->_template = null;
		$this->_filename = $filename;
		$this->_params   = $params;
	}


	function setTemplate(pfc_Template $template){
		$this->_template = $template;
	}


	function process(){
		if ($this->_template == null)
			throw new ControllerException("Controller Template is null");

		$this->_template->bindParams($this->_params);

		$content = $this->_template->render($this->_filename);

		return new \pfc\HTTPResponse($content);
	}
}

