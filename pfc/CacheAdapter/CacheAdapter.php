<?
namespace pfc\CacheAdapter;


/**
 * Adapter for implement caching
 *
 * data is usually serialized using Serializer
 *
 */
interface CacheAdapter{
	/**
	 * set time to live
	 *
	 * @param int $ttl
	 */
	function setTTL($ttl);


	/**
	 * load key from cache
	 *
	 * @param string $key key to be load
	 *
	 * @return string|mixed|boolean
	 */
	function load($key);


	/**
	 * store key/data into cache
	 *
	 * @param string $key key to be load
	 * @param string $data data to be stored
	 *
	 * @return string|mixed|boolean
	 */
	function store($key, $data);


	/**
	 * remove key from cache
	 *
	 * @param string $key key to be removed
	 *
	 * @return string|mixed|boolean
	 */
	function remove($key);
}

