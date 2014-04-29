<?
namespace pfc\CacheAdapter;

use pfc\CacheAdapter;
use pfc\UnitTest;

class Redis implements CacheAdapter, UnitTest{
	private $_redis;
	private $_keyPrefix;


	function __construct($redis, $keyPrefix = ""){
		$this->_redis      = $redis;
		$this->_keyPrefix  = $keyPrefix;
	}


	function load($key, $ttl){
		$data = $this->_redis->get( $this->getKey($key) );

		if ($data)
			return $data;

		return false;
	}


	function store($key, $ttl, $data){
		$this->_redis->set($this->getKey($key), $data );

		if ($ttl > 0){
			$this->_redis->expire( $this->getKey($key), $ttl );
		}
	}


	private function getKey($key){
		return $this->_keyPrefix . md5($key);
	}


	static function test(){
		$r = new \Redis();
		$r->connect("localhost", 6379);

		$adapter = new Redis($r, "unit_test_");

		$key  = "100";
		$data = "hello";
		$ttl  = 1;

		$adapter->store($key, $ttl, $data);
		$data1 = $adapter->load($key, $ttl);

		assert($data === $data1);

		echo "Delay: $ttl++ seconds... ";
		sleep($ttl + 1);
		echo "done.\n";

		$data1 = $adapter->load($key, $ttl);
		assert($data1 == false);
	}
}

