<?
namespace pfc\Loader;

use pfc\Loader;


/**
 * Load data from array()
 *
 */
class ArrayLoader implements Loader{
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
		$loader = new self(array(
			"test"	=> "test"		,
			"array"	=> array("test", "bla")	,
		));
		
		assert($loader->load("test") == "test");
		assert($loader->load("array")[0] == "test");
	}
}

