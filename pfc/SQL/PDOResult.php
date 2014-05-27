<?
namespace pfc\SQL;

use pfc\SQLResult;
use pfc\SQLException;

/**
 * PDO adapter for SQLResult
 *
 */
class PDOResult implements SQLResult{
	const FETCH_MODE = \PDO::FETCH_ASSOC;


	use TraitGet;


	private $_pdo;
	private $_insertID;

	private $_row;
	private $_rowID;


	function __construct(\PDOStatement $query, $primaryKey, $insertID = 0){
		$this->_pdo        = $query;
		$this->_insertID   = $insertID;
		$this->_primaryKey = $primaryKey;

		$this->_row        = false;
		$this->_rowID      = 0;
	}


	function affectedRows(){
		return $this->_pdo->rowCount();
	}


	function insertID(){
		return  $this->_insertID;
	}


	// =============================


	function rewind(){
		if ($this->_rowID == 0){
			// Rewind is OK as long as hasNext() is not called.
			return;
		}

		throw new SQLException("SQLResult_pdo->rewind() unimplemented");
	}


	function current(){
		if ($this->_rowID == 0){
			// fetch first result
			$this->next();
		}

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
		$this->_row = $this->_pdo->fetch(self::FETCH_MODE);
	}


	function valid(){
		if ($this->_rowID == 0)
			return true;

		return $this->_row !== false;
	}

	// =============================

}

