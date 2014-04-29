<?
namespace pfc;


/**
 * Adapter for implement caching
 * 
 * data is usually serialized using Serializer
 *
 */
interface CacheAdapter{
	/**
	 * load key from cache
	 * 
	 * @param string $key key to be load
	 * @param int $ttl cache TTL
	 * 
	 * @return string|mixed|boolean
	 */
	function load( $key, $ttl);

	
	/**
	 * store key/data into cache
	 * 
	 * @param string $key key to be load
	 * @param int $ttl cache TTL
	 * @param string $data data to be stored
	 * 
	 * @return string|mixed|boolean
	 */
	function store($key, $ttl, $data);
}

