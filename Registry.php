<?
namespace pfc;


/**
 * Registry
 *
 * Class for organizing relatively simple information,
 * such configuration data.
 *
 * All "keys" and "values" are files stored into the some directory,
 * "keys" are filenames,
 * "values" are content of the files:
 *
 * ...scalars:
 *
 * < ? return "secret"; ? >
 *
 * ...or array:
 *
 * < ?
 * return array(
 *      "host" => "localhost",
 *      "port" => 80
 * );
 * ? >
 *
 * ...or even class:
 *
 * < ?
 * class Bla{
 * }
 *
 * return new Bla();
 * ? >
 *
 * Once retrieved, data is stored in memory.
 *
 * In case of classes, this is equivalent to Singleton pattern.
 *
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
	function __construct(RegistryLoader $loader){
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
		$loader = new RegistryLoader\Dir(__DIR__ . "/data/config");

		$registry = new Registry($loader);

		assert($registry->get("test") == "test");
		assert($registry->get("array")[0] == "test");
	}
}


