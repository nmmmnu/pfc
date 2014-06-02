<?
namespace pfc\CacheAdapter;

class Shm extends File{
	function __construct($file_prefix, $unlink_files = true){
		$dir = "/dev/shm";

		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
			$dir = sys_get_temp_dir();

		parent::__construct($dir, $file_prefix, $unlink_files);
	}

	static function test(){
		$ttl = \pfc\UnitTests\CacheAdapterTests::TTL;

		$adapter = new Shm("unit_tests_Shm_CacheAdapter_");
		$adapter->setTTL($ttl);

		\pfc\UnitTests\CacheAdapterTests::test($adapter);
	}
}



