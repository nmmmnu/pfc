<?
namespace pfc\CacheAdapter;

use pfc\CacheAdapter;

/**
 * NULL CacheAdapter
 *
 */
class NULLAdapter implements CacheAdapter{
	function __construct(){
	}

	function load($key, $ttl){
		return false;
	}

	function store($key, $ttl, $data){
	}
}

