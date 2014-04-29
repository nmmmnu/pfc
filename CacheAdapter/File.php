<?
namespace pfc\CacheAdapter;

use pfc\CacheAdapter;
use pfc\UnitTest;

class File implements CacheAdapter, UnitTest{
	private $_adapter;


	function __construct(CacheAdapter $adapter){
		$this->_adapter = $_adapter;
	}


	function load($key, $ttl){
		$cacheGood = $this->checkTTL($key, $ttl);

		if (!$cacheGood)
			return false;

		$data = @file_get_contents($this->getFilename($key));

		// File not good.
		if ($data === false)
			return false;

		return $data;
	}


	function store($key, $ttl, $data){
		@file_put_contents( $this->getFilename($key), $data );
	}


	private function checkTTL($key, $ttl){
		// Cache is always good.
		if ($ttl == 0)
			return true;

		$mtime = @filemtime($this->getFilename($key));

		// Kind a error. Cache is bad.
		if ( $mtime == 0 )
			return false;

		// Cache expired.
		if ( $mtime + $ttl < time() ){
			if ($this->fileUnlink)
				@unlink($this->getFilename($key));

			return false;
		}

		return true;
	}


	private function getFilename($key){
		return $this->dir . "/" . $this->filePrefix . md5($key);
	}


	static function test(){
		$adapter = new File("/dev/shm/", "unit_test_");

		$key  = "100";
		$data = "hello";
		$ttl  = 1;

		$adapter->store($key, $ttl, $data);
		$data1 = $adapter->load($key, $ttl);

		//echo "$data \n $data1 'n";

		assert($data == $data1);

		echo "Delay: $ttl++ seconds... ";
		sleep($ttl + 1);
		echo "done.\n";

		$data1 = $adapter->load($key, $ttl);
		assert($data1 == false);
	}
}

