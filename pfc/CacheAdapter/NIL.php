<?
namespace pfc\CacheAdapter;


/**
 * NULL CacheAdapter
 *
 */
class NIL implements CacheAdapter{
	function setTTL($ttl){
	}

	function load($key){
		return false;
	}

	function store($key, $data){
	}

	function remove($key){
	}
}

