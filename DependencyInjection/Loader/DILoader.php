<?
namespace pfc\DependencyInjection\Loader;


use pfc\DependencyInjection\Callback;
use pfc\DependencyInjection\Loader;
use pfc\DependencyInjection\Dependency;


/**
 * Load data from Callback + Dependency
 *
 */
class DILoader implements Loader{
	private $_dependency;


	function __construct(Dependency $dependency){
		$this->_dependency = $dependency;
	}


	function load($key){
		$callback = new Callback($key);
		return $callback->exec($this->_dependency);
	}


	/* tests */

	static function test(){
		// tests are in DependencyInjectionTests
	}
}

