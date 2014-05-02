<?
namespace pfc\CacheAdapter;

use pfc\CacheAdapter;
use pfc\Compressor;
use pfc\UnitTest;

/**
 * CompressorDecorator CacheAdapter
 * This decorator compress the data from the CacheAdapter using Compressor
 *
 */
class CompressorDecorator implements CacheAdapter, UnitTest{
	private $_adapter;
	private $_compressor;

	/**
	 * constructor
	 *
	 * @param Serializer $serializer
	 * @param Compressor $compressor
	 */
	function __construct(CacheAdapter $adapter, Compressor $compressor){
		$this->_adapter = $adapter;
		$this->_compressor = $compressor;
	}


	function load($key, $ttl){
		$data = $this->_adapter->load($key, $ttl);

		if ($data === false)
			return false;

		$data = $this->_compressor->inflate($data);

		if ($data === false)
			return false;

		return $data;
	}


	function store($key, $ttl, $data){
		$data = $this->_compressor->deflate($data);

		$this->_adapter->store($key, $ttl, $data);
	}


	static function test(){
		$fileAdapter = new File("/dev/shm/", "unit_test_compress_");
		$adapter = new CompressorDecorator($fileAdapter, new \pfc\Compressor\GZip() );

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

