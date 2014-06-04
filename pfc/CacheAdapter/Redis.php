<?
namespace pfc\CacheAdapter;


class Redis implements CacheAdapter{
	private $_redis;
	private $_keyPrefix;

	private $_ttl = 0;


	function __construct($redis, $keyPrefix){
		$this->_redis      = $redis;
		$this->_keyPrefix  = $keyPrefix;
	}


	function setTTL($ttl){
		$this->_ttl        = $ttl;
	}


	function load($key){
		$data = $this->_redis->get( $this->getKey($key) );

		if ($data)
			return $data;

		return false;
	}


	function store($key, $data){
		$this->_redis->set($this->getKey($key), $data );

		if ($this->_ttl > 0)
			$this->_redis->expire( $this->getKey($key), $this->_ttl );
	}


	function remove($key){
		$this->_redis->del($this->getKey($key));
	}


	private function getKey($key){
		return $this->_keyPrefix . md5($key);
	}


	static function test(){
		$r = new \Redis();
		$r->connect("localhost");

		$ttl = \pfc\UnitTests\CacheAdapterTests::TTL;

		$adapter = new Redis($r, "unit_tests_Redis_CacheAdapter_");
		$adapter->setTTL($ttl);

		\pfc\UnitTests\CacheAdapterTests::test($adapter);
	}
}

