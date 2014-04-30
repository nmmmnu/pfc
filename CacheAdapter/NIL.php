<?
namespace pfc\CacheAdapter;

use pfc\CacheAdapter;

/**
 * NULL CacheAdapter
 *
 */
class NIL implements CacheAdapter{
	function load($key, $ttl){
		return false;
	}

	function store($key, $ttl, $data){
	}
}

