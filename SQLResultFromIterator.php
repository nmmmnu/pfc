<?
namespace pfc;

/**
 * Adapter that converts Iterator to SQLResult
 * 
 * Useful for Mock objects, but also for cache, JSON etc.
 *
 */
class SQLResultFromIterator implements SQLResult{
	private $_iterator;
	
	private $_primaryKey;
	private $_affectedRows;
	private $_insertID;

	/**
	 * constructor
	 *
	 * @param Iterator $iterator iterator with the row data
	 * @param string $primaryKey "primary key" for the array keys
	 * @param int $affectedRows affected rows value for affectedRows()
	 * @param int $insertID last insert id for insertID()
	 */
	function __construct(Iterator $iterator, $primaryKey = NULL, $affectedRows = -1, $insertID = 0){
		$this->_iterator     = $iterator;

		$this->_primaryKey   = $primaryKey;
		$this->_affectedRows = $affectedRows;
		$this->_insertID     = $insertID;
	}


	/**
	 * get affected rows (count of the array)
	 *
	 * @return int
	 */
	function affectedRows(){
		return $this->_affectedRows;
	}


	/**
	 * get last insert id
	 *
	 * @return int
	 */
	function insertID(){
		return $this->_insertID;
	}

	function rewind(){
		$this->_iterator->rewind();
	}

	function next(){
		return $this->_iterator->next();
	}

	function current(){
		return $this->_iterator->current();
	}
	
	function currentKey(){
		if ($this->_primaryKey == NULL)
			return NULL;
		
		$val = $this->_iterator->current();
		
		if (@$val[$this->_primaryKey])
			return $val[$this->_primaryKey];
		
		return NULL;
	}
}

