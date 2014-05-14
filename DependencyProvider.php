<?
namespace pfc;


class DependencyProvider {
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
	 * get an item from the DependencyProvider
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


