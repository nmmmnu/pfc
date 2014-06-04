<?
namespace pfc\Template;


/**
 * PHP template engine
 *
 */
class PHP implements Template{
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

			// keep classes with "_" in front.

			if (is_object($v) && $k[0] == "_"){
				$array[$k] = $v;
				continue;
			}

			// remove other types and clases
		}

		return $array;
	}


	static function test(){
		$t = new PHP(__DIR__ . "/../../data/templates/");

		\pfc\UnitTests\TemplateTests::test($t);
	}
}



