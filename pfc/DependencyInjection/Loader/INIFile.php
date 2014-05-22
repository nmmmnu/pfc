<?
namespace pfc\DependencyInjection\Loader;


use pfc\FileInclude;


/**
 * Load data from ini files in some directory
 *
 */
class INIFile extends FilesystemLoader{
	const FILE_EXT = ".ini";

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

		if (file_exists($filename)){
			$data = parse_ini_file($filename);

			if (is_array($data))
				return $data;
		}

		return null;
	}



	/* tests */

	static function test(){
		$loader = new self(__DIR__ . "/../../../data/ini");

		//print_r($loader->load("redis"));

		assert($loader->load("redis")["host"] == "localhost");
		assert($loader->load("mysql")["user"] == "admin");
	}
}

