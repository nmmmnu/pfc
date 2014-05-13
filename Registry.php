<?
namespace pfc;


/**
 * Registry
 *
 * Class for organizing relatively simple information,
 * such configuration data.
 *
 * Data is loaded using RegistryLoader such:
 * - RegistryLoader/PHP - load data from php files
 * - RegistryLoader/INI - load data from ini files
 *
 * This easily can be extend to load from
 * - array()
 * - class/method
 * - redis hash
 *
 * Once retrieved, data is stored in memory,
 * another reason data to be relatively small
 *
 * In case of classes, this is equivalent to Singleton pattern.
 * However the Registry is mainly made for scalars and arrays.
 *
 */
class Registry {
	private $_data = array();
	private $_loader;


	/**
	 * constructor
	 * @param string $path directory where registry files are placed
	 * @param string $ext file extention
	 *
	 */
	function __construct(Loader $loader){
		$this->_loader = $loader;
	}


	/**
	 * get an item from the Registry
	 * @param string $item
	 * @return mixed|null
	 *
	 */
	function get($key) {
		if (isset($this->_data[$key]))
			return $this->_data[$key];

		$value = $this->_loader->load($key);

		if ($value !== null){
			$this->_data[$key] = $value;
			return $value;
		}

		return null;
	}


	/* tests */

	static function test(){
		$loader = new Loader\ArrayLoader(array(
			"test"	=> "test"	,
			"array"	=> array("test", "bla")
		));

		$registry = new self($loader);

		assert($registry->get("test") == "test");
		assert($registry->get("array")[0] == "test");
	}
}


