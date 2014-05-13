<?
namespace pfc\RegistryLoader;

use pfc\RegistryLoader;
use pfc\Callback as pfc_Callback;


/**
 * Load data from Callbacks
 *
 */
class Callback implements RegistryLoader{
	private $_factory;


	function __construct(CallbackFactory $factory){
		$this->_factory = $factory;
	}


	function load($key){
		$callback = $this->_factory->getCallback($key);

		return $callback->exec();
	}



	/* tests */

	static function test(){
		// no tests really
	}
}

