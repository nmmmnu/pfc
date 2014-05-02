<?
namespace pfc\CacheAdapter;

use pfc\CacheAdapter;

class Redis implements CacheAdapter{
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

		if ($ttl > 0)
			$this->_redis->expire( $this->getKey($key), $ttl );
	}


	private function getKey($key){
		return $this->_keyPrefix . md5($key);
	}


	static function test(){
		$r = new \Redis();
		$r->connect("localhost");

		$adapter = new Redis($r, "unit_tests_[" . __CLASS__ ."]_");

		\pfc\CacheAdapterTests::test($adapter);
	}
}

