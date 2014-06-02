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


	function setTTL($ttl){
		$this->_adapter.setTTL($ttl);
	}


	function load($key){
		$data = $this->_adapter->load($key);

		if ($data === false)
			return false;

		$data = $this->_compressor->inflate($data);

		if ($data === false)
			return false;

		return $data;
	}


	function store($key, $data){
		$data = $this->_compressor->deflate($data);

		$this->_adapter->store($key, $data);
	}


	function remove($key){
		$this->_adapter->remove($key);
	}


	static function test(){
		$ttl = \pfc\UnitTests\CacheAdapterTests::TTL;

		$fileAdapter = new Shm("unit_tests_CompressorDecorator_CacheAdapter_");
		$fileAdapter->setTTL($ttl);

		$compressor  = new \pfc\Compressor\GZip();
		$adapter = new CompressorDecorator($fileAdapter, $compressor);

		\pfc\UnitTests\CacheAdapterTests::test($adapter);
	}
}

