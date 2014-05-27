<?
namespace pfc\SQL;

use pfc\SQLResult;
use pfc\SQLTools;

/**
 * PDO adapter for SQLResult
 *
 */
class MySQLiResult implements SQLResult{
	const FETCH_MODE = \PDO::FETCH_ASSOC;


	private $_results;

	private $_row;
	private $_rowID;

	function __construct($query, $primaryKey){
		$this->_results    = $query;
		$this->_primaryKey = $primaryKey;

		$this->_row        = false;
		$this->_rowID      = 0;
	}


	function affectedRows(){
		return $this->_results->num_rows;
	}


	function insertID(){
		return 0;
	}



	function get($field = false){
		return SQLTools::getResult($this, $field);
	}


	// =============================


	function rewind(){
		if ($this->_rowID == 0){
			// Rewind is OK as long as hasNext() is not called.
			return;
		}

		throw new SQLException("SQLResult_results->rewind() unimplemented");
	}


	function current(){
		if ($this->_rowID == 0){
			// fetch first result
			$this->next();
		}

		if ($this->_row == null)
			return null;

		return $this->_row;
	}


	function key(){
		if ($this->_rowID == 0){
			// fetch first result
			$this->next();
		}

		if (! $this->_primaryKey )
			return $this->_rowID;

		if ( @$this->_row[$this->_primaryKey] )
			return $this->_row[$this->_primaryKey];
	}


	function next(){
		$this->_rowID++;
		$this->_row = $this->_results->fetch_assoc();
	}


	function valid(){
		if ($this->_rowID == 0)
			return true;

		return $this->_row !== null;
	}

	// =============================

}

