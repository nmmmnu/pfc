<?
namespace pfc\CacheAdapter;

class Shm extends File{
	function __construct($file_prefix, $unlink_files = true){
		parent::__construct("/dev/shm/", $file_prefix, $unlink_files);
	}


	static function test(){
		$ttl = \pfc\UnitTests\CacheAdapterTests::TTL;

		$adapter = new Shm("unit_tests_Shm_CacheAdapter_");
		$adapter->setTTL($ttl);

		\pfc\UnitTests\CacheAdapterTests::test($adapter);
	}
}



