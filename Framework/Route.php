<?
namespace pfc\Framework;


use pfc\Callback;
use pfc\ArrayList;
use pfc\DependencyProvider;
use pfc\Loader\ArrayLoader as Loader_ArrayLoader;


class Route{
	private $_path;
	private $_callback;
	private $_dependency;

	const PARAM_PATH = "_path";


	function __construct(Path $matcher, Callback $callback){
		$this->_path		= $matcher;
		$this->_callback	= $callback;
		$this->_dependency	= new ArrayList();
	}


	function match($path){
		$data = $this->_path->match($path);

		if (is_array($data)){
			// add path to params as well
			$data[self::PARAM_PATH] = $path;

			$this->_dependency->clear();
			$this->_dependency[] = new DependencyProvider(new Loader_ArrayLoader($data));


			return true;
		}

		return false;
	}


	function link(array $params){
		return $this->_path->link($params);
	}


	function exec(){
		return $this->_callback->exec($this->_dependency);
	}
}

