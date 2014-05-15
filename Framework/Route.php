<?
namespace pfc\Framework;


use pfc\DependencyInjection\Callback;
use pfc\DependencyInjection\Dependency;


class Route{
	private $_path;
	private $_callback;
	private $_dependency;
	private $_matchedArgs = null;
	private $_matchedPath = null;

	const PARAM_PATH = "_path";


	function __construct(Path $matcher, Callback $callback, Dependency $dependency = null){
		if (! $dependency)
			$dependency = new Dependency();

		$this->_path		= $matcher;
		$this->_callback	= $callback;
		$this->_dependency	= $dependency;
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
		$dependency = new Dependency();
		$dependency->addParent($this->_dependency);

		if (is_array($this->_matchedArgs))
			$dependency->addParent($this->_matchedArgs);

		if ($this->_matchedPath){
			$pathDep = array(
				self::PARAM_PATH => $this->_matchedPath
			);

			$dependency->addParent($pathDep);
		}

		return $this->_callback->exec($dependency);
	}
}

