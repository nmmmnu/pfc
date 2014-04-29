<?
namespace pfc\SQL;

use pfc\SQL;
use pfc\SQLArrayResult;
use pfc\SQLResultFromIterator;

use pfc\Iterators;
use pfc\ArrayIterator;

use pfc\CacheAdapter;
use pfc\Serializer;

/**
 * Decorator that caches the SQL using CacheAdapter and Serializer
 *
 */
class CacheDecorator implements SQL{
	private $_sqlAdapter;
	private $_cacheAdapter;
	private $_serializer;
	private $_ttl;


	/**
	 * constructor
	 *
	 * @param SQL $sqlAdapter
	 * @param CacheAdapter $cacheAdapter
	 * @param Serializer $serializer
	 * @param int $ttl time to live for the cache
	 */
	function __construct(SQL $sqlAdapter, CacheAdapter $cacheAdapter, Serializer $serializer, $ttl){
		$this->_sqlAdapter	= $sqlAdapter;
		$this->_cacheAdapter	= $cacheAdapter;
		$this->_serializer	= $serializer;
		$this->_ttl		= $ttl;
	}


	function getName(){
		return $this->_sqlAdapter->getName();
	}


	function open($connectionString){
		return $this->_sqlAdapter->open($connectionString);
	}


	function close(){
		return $this->_sqlAdapter->close();
	}


	function escape($string){
		return $this->_sqlAdapter->escape($string);
	}


	function query($sql, $primaryKey=NULL){
		//$key = $this->getHash($sql);

		// load from cache
		$serializedData = $this->_cacheAdapter->load($key, $this->_ttl);

		if ($serializedData !== false){
			$arrayData = $this->_serializer->unserialize($serializedData);
			unset($serializedData);

			// Corrupted data
			if (is_array($arrayData)){
				$this->debug("Cache hit!\n");
				return new SQLResultFromIterator(new ArrayIterator($arrayData), $primaryKey, count($arrayData) );
			}
		}

		$this->debug("Perform the query\n");

		// perform the query
		$result = $this->_sqlAdapter->query($sql, $primaryKey);

		if ($result === false)
			return false;

		// make the result array
		$arrayData = Iterators::toArray($result);

		// store in cache
		$serializedData = $this->_serializer->serialize($arrayData);
		$this->_cacheAdapter->store($key, $this->_ttl, $serializedData);
		unset($serializedData);

		// the iterator can not be rewind.
		// this is why we use the SQLMockResult again.
		return new SQLResultFromIterator(new ArrayIterator($arrayData), $primaryKey, $result->affectedRows(), $result->insertID() );
	}


	private $_debug = false;
	function setDebug($debug){
		$this->_debug = $debug;
	}


	function debug($string){
		if ($this->_debug == false)
			return;

		echo $string;
	}
}

