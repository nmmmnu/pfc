<?
namespace pfc\Template;

use pfc\Template;
use pfc\UnitTest;


/**
 * PHP template engine
 *
 */
class PHP implements Template, UnitTest{
	const MAXDEEP = 30;

	private $_path;
	private $_deep;

	private $_sandbox;


	/**
	 * constructor
	 *
	 * @param string $path directory where templates are located
	 */
	function __construct($path = ""){
		$this->_path = $path;
		$this->_deep = 0;
		$this->_vars = array();

		$this->_sandbox = new PHPSandbox($this);
	}


	function bindParam($key, $value){
		$this->_vars[$key] = $value;
	}


	function bindParams(array $array){
		foreach($array as $k => $v)
			$this->bindParam($k, $v);
	}


	function escape($string){
		return htmlentities($string);
	}


	function render($file, $content = ""){
		$this->_deep++;

		$vars_escaped = $this->multiEscape($this->_vars);

		$sandbox = new PHPSandbox($this);

		list($parentFile, $content) = $sandbox->callUserCode($this->_path . $file, $this->_vars, $vars_escaped, $content);

		if ($parentFile && $this->_deep < self::MAXDEEP){
			$content = $this->render($parentFile, $content);
		}

		$this->_deep--;

		return $content;
	}


	private function multiEscape($vars){
		$array = array();

		foreach($vars as $k => $v){
			if (is_scalar($v)){
				$array[$k] = $this->escape($v);
				continue;
			}

			if (is_array($v)){
				$array[$k] = $this->multiEscape($v);
				continue;
			}

			// remove other types such is_object()
		}

		return $array;
	}


	static function test(){
		$t = new PHP("data/templates/");

		$params = array(
			"name"		=> "Niki\"",
			"city"		=> "Sofia"
		);

		$t->bindParams($params);

		echo "You will see template HTML file here:\n";
		echo $t->render("page.html.php");
		echo "end\n";
	}
}


