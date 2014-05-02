<?
namespace pfc;

class CacheAdapterTests{
	static function test(CacheAdapter $adapter){
		$key  = "100";
		$data = "hello, this is some test data";
		$ttl  = 1;

		$adapter->store($key, $ttl, $data);
		$data1 = $adapter->load($key, $ttl);

		assert($data == $data1);

		echo "Delay: " . ($ttl + 1) . " seconds... ";
		sleep($ttl + 1);
		echo "done.\n";

		$data1 = $adapter->load($key, $ttl);
		assert($data1 === false);
	}
}

