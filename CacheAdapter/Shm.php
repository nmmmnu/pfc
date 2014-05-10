<?
namespace pfc\CacheAdapter;

class Shm extends File{
	function __construct($file_prefix, $unlink_files = true){
		$dir = "/dev/shm";
		parent::__construct($dir, $file_prefix, $unlink_files);
	}

	static function test(){
		$ttl = \pfc\UnitTests\CacheAdapterTests::TTL;

		$adapter = new Shm("unit_tests_[" . __CLASS__ ."]_");
		$adapter->setTTL($ttl);

		\pfc\UnitTests\CacheAdapterTests::test($adapter);
	}
}



