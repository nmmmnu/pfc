<?
namespace pfc\RegistryLoader;

use pfc\RegistryLoader;
use pfc\Callback as pfc_Callback;


/**
 * Load data from array()
 *
 */
class ArrayLoader implements RegistryLoader{
	private $_storage;


	function __construct( array $storage = array() ){
		$this->_storage = $storage;
	}


	function load($key){
		if (isset($this->_storage[$key]))
			return $this->_storage[$key];

		return null;
	}



	/* tests */

	static function test(){
		// no tests really
	}
}

