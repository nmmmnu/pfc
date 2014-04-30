<?
namespace pfc\CacheAdapter;

use pfc\CacheAdapter;
use pfc\UnitTest;

/**
 * GZipDecorator CacheAdapter
 * This decorator compress the data from the CacheAdapter to gzip format
 * If written to file, utilities like gzip / zcat can be used
 *
 */
class GZipDecorator implements CacheAdapter, UnitTest{
	private $_adapter;

	/**
	 * constructor
	 *
	 * @param Serializer $serializer
	 */
	function __construct(CacheAdapter $adapter){
		$this->_adapter = $adapter;
	}


	function load($key, $ttl){
		$data = $this->_adapter->load($key, $ttl);

		if ($data === false)
			return false;

		$data = @gzdecode($data);

		if ($data === false)
			return false;

		return $data;
	}


	function store($key, $ttl, $data){
		$data = gzencode($data);

		$this->_adapter->store($key, $ttl, $data);
	}


	static function test(){
		$fileAdapter = new File("/dev/shm/", "unit_test_gzip_");
		$adapter = new GZipDecorator($fileAdapter);

		$key  = "100";
		$data = "hello";
		$ttl  = 1;

		$adapter->store($key, $ttl, $data);
		$data1 = $adapter->load($key, $ttl);

		//echo "$data \n $data1 'n";

		assert($data == $data1);

		echo "Delay: " . ($ttl + 1) . " seconds... ";
		sleep($ttl + 1);
		echo "done.\n";

		$data1 = $adapter->load($key, $ttl);
		assert($data1 == false);
	}
}

