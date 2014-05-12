<?
namespace pfc\Framework;


use pfc\Callback;


class Route{
	private $_path;
	private $_callback;
	private $_params;

	const PARAM_PATH = "_path";


	function __construct(Path $matcher, Callback $callback){
		$this->_path     = $matcher;
		$this->_callback = $callback;
		$this->_params   = $callback->getParams();
	}

	function match($path){
		$data = $this->_path->match($path);

		if (is_array($data)){
			$data[self::PARAM_PATH] = $path;

			$this->setParams($data);

			return true;
		}

		return false;
	}

	function link(array $params){
		return $this->_path->link($params);
	}

	function exec(){
		return $this->_callback->exec();
	}

	private function setParams(array $data){
		foreach(array_keys($this->_params) as $k)
			if (! isset($data[$k]))
				$data[$k] = $this->_params[$k];

		$this->_callback->setParams($data);
	}
}

