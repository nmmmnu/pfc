<?
namespace pfc\Framework;


class Route{
	private $_path;
	private $_callback;
	private $_injector;

	private $_matchedArgs = null;
	private $_matchedPath = null;

	const PARAM_PATH = "_path";

	const PARAM_CONF = "Route_Configuration";

	const DELIMITER  = "::";

	function __construct(Path $matcher, \injector\AbstractInjector $injector, $callback){
		$this->_path		= $matcher;
		$this->_callback	= explode(self::DELIMITER, $callback);
		$this->_injector	= $injector;
	}


	function match($path){
		$data = $this->_path->match($path);

		if (is_array($data)){
			// add path to params as well
			$this->_matchedArgs = $data;
			$this->_matchedPath = $path;

			return true;
		}

		return false;
	}


	function link(array $params){
		return $this->_path->link($params);
	}


	function exec(){
		$conf  = new \injector\Configuration();

		if (is_array($this->_matchedArgs)){
			foreach($this->_matchedArgs as $k => $v)
				$conf->bind($k, new \injector\BindValue($v));
		}

		if ($this->_matchedPath){
				$conf->bind(self::PARAM_PATH, new \injector\BindValue($this->_matchedPath));
		}

		$this->_injector->specifications()[self::PARAM_CONF] = $conf;

		$value = $this->_injector->callMethod($this->_callback[0], $this->_callback[1]);

		unset($this->_injector->specifications()[self::PARAM_CONF]);

		return $value;
	}
}

