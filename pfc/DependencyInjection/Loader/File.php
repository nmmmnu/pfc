<?
namespace pfc\DependencyInjection\Loader;


/**
 * Load data from directory
 *
 * can load clases, but it is intended to load scalars and arrays.
 *
 * files must looks like:
 *
 * < ? return array(1,2,3,4); ? >
 *
 */
class File extends FilesystemLoader{
	const FILE_EXT = ".php";


	/**
	 * constructor
	 * @param string $path directory where registry files are placed
	 * @param string $ext file extention
	 *
	 */
	function __construct($path, $ext = self::FILE_EXT){
		parent::__construct($path, $ext);
	}


	function load($key){
		$filename = $this->getFileName($key);

		if (file_exists($filename))
			return include $filename;

		return null;
	}



	/* tests */

	static function test(){
		$loader = new self(__DIR__ . "/../../../data/config");

		assert($loader->load("test") == "test");
		assert($loader->load("array")[0] == "test");
		assert($loader->load("class")->test == "test");
	}
}

