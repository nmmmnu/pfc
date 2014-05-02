<?
namespace pfc\CacheAdapter;

use pfc\CacheAdapter;
use pfc\Compressor;
use pfc\CacheAdapterTests;

/**
 * CompressorDecorator CacheAdapter
 * This decorator compress the data from the CacheAdapter using Compressor
 *
 */
class CompressorDecorator implements CacheAdapter{
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
		$fileAdapter = new File("/dev/shm/", "unit_tests_[" . __CLASS__ ."]_");
		$compressor  = new \pfc\Compressor\GZip();
		$adapter = new CompressorDecorator($fileAdapter, $compressor );

		\pfc\CacheAdapterTests::test($adapter);
	}
}

