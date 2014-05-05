<?
namespace pfc\CacheAdapter;

class Shm extends File{
	function __construct($file_prefix = "", $unlink_files = true){
		$dir = "/dev/shm";
		parent::__construct($dir, $file_prefix, $ttl, $unlink_files);
	}

	static function test(){
		$ttl = \pfc\CacheAdapterTests::TTL;

		$adapter = new Shm("unit_tests_[" . __CLASS__ ."]_");
		$adapter->setTTL(\pfc\CacheAdapterTests::TTL);

		\pfc\CacheAdapterTests::test($adapter);
	}
}



