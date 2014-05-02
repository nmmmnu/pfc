<?
namespace pfc\CacheAdapter;

use pfc\CacheAdapter;

class File implements CacheAdapter{
	private $_dir;
	private $_filePrefix;
	private $_fileUnlink;


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
			if ($this->_fileUnlink)
				@unlink($this->getFilename($key));

			return false;
		}

		return true;
	}


	private function getFilename($key){
		return $this->_dir . "/" . $this->_filePrefix . md5($key);
	}


	static function test(){
		$adapter = new File("/dev/shm/", "unit_tests_[" . __CLASS__ ."]_");

		\pfc\CacheAdapterTests::test($adapter);
	}
}

