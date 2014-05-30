<?
namespace pfc\Template;

use pfc\Template;

abstract class PHPSandboxPrivate{
	private $_engine;
	private $_parent;


	function __construct(Template $engine){
		$this->_engine = $engine;
		$this->_parent = false;
	}


	protected function extend($file){
		$this->_parent = $file;
	}


	protected function getParent(){
		return $this->_parent;
	}


	protected function escape($string){
		return $this->_engine->escape($string);
	}


	protected function render($file){
		return $this->_engine->render($file);
	}

	abstract function callUserCode($_file, $_vars, $_vars_escaped, $_content);
}


class PHPSandbox extends PHPSandboxPrivate{
	function __construct(Template $engine){
		parent::__construct($engine);
	}


	function callUserCode($_file, $_vars, $_vars_escaped, $_content){
		extract($_vars_escaped, EXTR_SKIP);
		unset($_vars_escaped);

		ob_start();
		require $_file;
		$result = ob_get_clean();

		return array($this->getParent(), $result);
	}
}


