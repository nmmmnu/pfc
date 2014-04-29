<?
namespace pfc\SQL;

use pfc\SQLResult;

/**
 * PDO adapter for SQLResult
 *
 */
class PDOResult implements SQLResult{
	const FETCH_MODE = \PDO::FETCH_ASSOC;

	private $_query;
	private $_insertID;

	private $_first = true;

	private $_tempRow;

	
	function __construct(\PDOStatement $query, $primaryKey, $insertID=0){
		$this->_query      = $query;
		$this->_insertID   = $insertID;
		$this->_primaryKey = $primaryKey;
	}

	
	function affectedRows(){
		return $this->_query->rowCount();
	}

	
	function insertID(){
		return  $this->_insertID;
	}

	
	function rewind(){
		if ($this->_first){
			// Rewind is OK as long as hasNext() is not called.
			return;
		}

		throw new Exception("SQLResult_pdo->rewind() unimplemented");
	}
	

	function next(){
		$this->_first = false;

		$this->_tempRow = $this->_query->fetch(self::FETCH_MODE);

		if ($this->_tempRow === false)
			return false;

		return $this->_tempRow;
	}

	
	function current(){
		return $this->_tempRow;
	}
	
	
	function currentKey(){
		if (! $this->_primaryKey )
			return NULL;
			
		if ( @$this->_tempRow[$this->_primaryKey] )
			return $this->_tempRow[$this->_primaryKey];
			
		return NULL;
	}
}

