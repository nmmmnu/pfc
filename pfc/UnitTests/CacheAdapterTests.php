<?
namespace pfc\UnitTests;

use pfc\CacheAdapter;

class CacheAdapterTests{
	const TTL = 1;

	static function test(CacheAdapter $adapter){
		$key  = "100";
		$data = "hello, this is some test data";

		$adapter->store($key, $data);
		$data1 = $adapter->load($key);

		assert($data == $data1);

		echo "Delay: " . (self::TTL + 1) . " seconds... ";
		sleep(self::TTL + 1);
		echo "done.\n";

		$data1 = $adapter->load($key);
		assert($data1 === false);
	}
}

