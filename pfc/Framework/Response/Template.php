<?
namespace pfc\Framework\Response;


use pfc\Framework\Response;
use pfc\Framework\ControllerException;
use pfc\HTTPResponse;
use pfc\Template\Template as pfc_Template;


class Template implements Response{
	private $_template;
	private $_filename;
	private $_params;
	private $_code;


	function __construct($filename, array $params = array(), $code = 0){
		$this->_template	= null;
		$this->_filename	= $filename;
		$this->_params		= $params;
		$this->_code		= $code;
	}


	function setTemplate(pfc_Template $template){
		$this->_template = $template;
	}


	function process(){
		if ($this->_template == null)
			throw new ControllerException("Controller Template is null");

		$this->_template->bindParams($this->_params);

		$content = $this->_template->render($this->_filename);

		return new HTTPResponse($content, HTTPResponse::DEFAULT_CONTENT_TYPE, $this->_code);
	}


	static function test(){
		$tr = new self("page.html.php");
		$tr->setTemplate( new \pfc\Template\PHP(__DIR__ . "/../../../data/templates/") );
		\pfc\UnitTests\ResponseTests::test($tr);
	}
}

