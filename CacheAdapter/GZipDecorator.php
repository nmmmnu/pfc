<?
namespace pfc\CacheAdapter;

use pfc\CacheAdapter;
use pfc\Compressor\GZip;

/**
 * GZipDecorator CacheAdapter
 * This decorator compress the data from the CacheAdapter to gzip format
 * If written to file, utilities like gzip / zcat can be used
 *
 */
class GZipDecorator extends CompressorDecorator{
	/**
	 * constructor
	 *
	 * @param Serializer $serializer
	 */
	function __construct(CacheAdapter $adapter){
		parent::__construct($adapter, new GZip());
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

