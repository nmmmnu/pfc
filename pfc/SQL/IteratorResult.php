<?
namespace pfc\SQL;

use pfc\SQLResult;
use pfc\SQLTools;

/**
 * Adapter that converts Iterator to SQLResult
 *
 * Useful for Mock objects, but also for cache, JSON etc.
 *
 */
class IteratorResult implements SQLResult{
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
	function __construct(\Iterator $iterator, $primaryKey = false, $affectedRows = -1, $insertID = 0){
		$this->_iterator     = $iterator;

		$this->_primaryKey   = $primaryKey;
		$this->_affectedRows = $affectedRows;
		$this->_insertID     = $insertID;
	}


	function affectedRows(){
		return $this->_affectedRows;
	}


	function insertID(){
		return $this->_insertID;
	}


	function get($field = false){
		return SQLTools::getResult($this, $field);
	}


	// =============================

	function rewind(){
		return $this->_iterator->rewind();
	}


	function current(){
		return $this->_iterator->current();
	}


	function key(){
		if ($this->_primaryKey){
			$val = $this->_iterator->current();

			if (@$val[$this->_primaryKey])
				return $val[ $this->_primaryKey ];
		}

		return $this->_iterator->key();
	}


	function next(){
		return $this->_iterator->next();
	}


	function valid(){
		return $this->_iterator->valid();
	}

	// =============================

}
