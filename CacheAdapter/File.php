<?
namespace pfc\CacheAdapter;

use pfc\CacheAdapter;

class File implements CacheAdapter{
	private $_dir;
	private $_filePrefix;
	private $_fileUnlink;
	private $_ttl = 0;


	/**
	 * constructor
	 *
	 * @param string $dir path for files location
	 * @param string $filePrefix file prefix
	 * @param boolean $fileUnlink whatever to unlink (delete) expired files
	 *
	 */
	function __construct($dir, $filePrefix, $fileUnlink = false){
		$this->_dir        = $dir;
		$this->_filePrefix = $filePrefix;
		$this->_fileUnlink = $fileUnlink;
	}


	function setTTL($ttl){
		$this->_ttl        = $ttl;
	}


	function load($key){
		$cacheGood = $this->checkTTL($key);

		if (!$cacheGood)
			return false;


		$data = @file_get_contents($this->getFilename($key));

		// File not good.
		if ($data === false)
			return false;

		return $data;
	}


	function store($key, $data){
		@file_put_contents( $this->getFilename($key), $data );
	}


	function remove($key){
		if ($this->_fileUnlink)
			@unlink($this->getFilename($key));
	}


	private function checkTTL($key){
		// Cache is always good.
		if ($this->_ttl == 0)
			return true;

		$mtime = @filemtime($this->getFilename($key));

		// Kind a error. Cache is bad.
		if ( $mtime == 0 )
			return false;

		// Cache expired.
		if ( $mtime + $this->_ttl < time() ){
			$this->remove($key);
			return false;
		}

		return true;
	}


	private function getFilename($key){
		return $this->_dir . "/" . $this->_filePrefix . md5($key);
	}


	static function test(){
		$ttl = \pfc\UnitTests\CacheAdapterTests::TTL;

		$adapter = new File("/dev/shm/", "unit_tests_[" . __CLASS__ ."]_");
		$adapter->setTTL($ttl);

		\pfc\UnitTests\CacheAdapterTests::test($adapter);
	}
}

