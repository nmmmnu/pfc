<?
namespace pfc\RegistryLoader;

use pfc\RegistryLoader;
use pfc\Callback as pfc_Callback;


/**
 * Load data from directory
 *
 */
class Callback implements RegistryLoader{
	private $_storage;


	function __construct(\ArrayAccess $storage = null){
		$this->_storage = $storage;
	}


	function load($key){
		$callback = new pfc_Callback($key);
		$callback->setObjectStorage($this->_storage);

		return $callback->exec();
	}



	/* tests */

	static function test(){
		// no tests really
	}
}

