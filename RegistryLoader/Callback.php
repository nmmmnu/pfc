<?
namespace pfc\RegistryLoader;

use pfc\RegistryLoader;
use pfc\Callback as pfc_Callback;


/**
 * Load data from directory
 *
 */
class Callback implements RegistryLoader{
	function load($key){
		$callback = new pfc_Callback($key);

		return $callback->exec();
	}


	/* tests */

	static function test(){
		// no tests really
	}
}

