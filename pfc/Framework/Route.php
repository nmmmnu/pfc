<?
namespace pfc\Framework;


class Route{
	private $_path;
	private $_controller;

	private $_matchedArgs = null;
	private $_matchedPath = null;

	function __construct(Path\Path $matcher, Controller\Controller $controller){
		$this->_path		= $matcher;
		$this->_controller	= $controller;
	}


	function match($path){
		$data = $this->_path->match($path);

		if (is_array($data)){
			$this->_controller->setRouting($path, $data);

			return $this->_controller;
		}

		return false;
	}


	function link(array $params){
		return $this->_path->link($params);
	}
}

