<?
namespace pfc\SQL;

use pfc\SQL;
use pfc\SQLTools;

use pfc\Loggable;
use pfc\Logger;

use pfc\Iterators;
use pfc\ArrayIterator;

use pfc\CacheAdapter;
use pfc\Serializer;

/**
 * Decorator that caches the SQL using CacheAdapter and Serializer
 *
 */
class CacheDecorator implements SQL{
	use Loggable;


	private $_sqlAdapter;
	private $_cacheAdapter;
	private $_serializer;


	/**
	 * constructor
	 *
	 * @param SQL $sqlAdapter
	 * @param CacheAdapter $cacheAdapter
	 * @param Serializer $serializer
	 */
	function __construct(SQL $sqlAdapter, CacheAdapter $cacheAdapter, Serializer $serializer, Logger $logger = null){
		$this->_sqlAdapter	= $sqlAdapter;
		$this->_cacheAdapter	= $cacheAdapter;
		$this->_serializer	= $serializer;

		$this->setLogger($logger);
	}


	function getName(){
		return $this->_sqlAdapter->getName();
	}


	function getParamsHelp(){
		return $this->_sqlAdapter->getParamsHelp();
	}


	function open(){
		return $this->_sqlAdapter->open();
	}


	function close(){
		return $this->_sqlAdapter->close();
	}


	function escape($string){
		return $this->_sqlAdapter->escape($string);
	}


	function query($sql, array $params, $primaryKey = null){
		$originalSQL = $sql;
		$sql = SQLTools::escapeQuery($this, $sql, $params);
		// load from cache
		$serializedData = $this->_cacheAdapter->load($sql);

		if ($serializedData !== false){
			$arrayData = $this->_serializer->unserialize($serializedData);
			unset($serializedData);

			// Corrupted data
			if (is_array($arrayData)){
				$this->logDebug("Cache hit...");
				return new IteratorResult(new \ArrayIterator($arrayData), $primaryKey, count($arrayData) );
			}
		}

		$this->logDebug("Perform the query...");

		// perform the query
		$result = $this->_sqlAdapter->query($originalSQL, $params, $primaryKey);

		if ($result === false)
			return false;

		// make the result array
		$arrayData = Iterators::toArray($result);

		// store in cache
		$serializedData = $this->_serializer->serialize($arrayData);
		$this->_cacheAdapter->store($sql, $serializedData);
		unset($serializedData);

		// the iterator can not be rewind.
		// this is why we use the SQLMockResult again.
		return new IteratorResult(new \ArrayIterator($arrayData), $primaryKey, $result->affectedRows(), $result->insertID() );
	}
}

