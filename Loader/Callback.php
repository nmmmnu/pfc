<?
namespace pfc\Loader;

use pfc\Loader;
use pfc\CallbackFactory;


/**
 * Load data from Callbacks
 *
 */
class Callback implements Loader{
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

