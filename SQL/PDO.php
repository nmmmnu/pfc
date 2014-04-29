<?
namespace pfc\SQL;

use pfc\SQL;

/**
 * PDO adapter
 *
 * query always returns the array passed by constructor
 *
 */
class PDO implements SQL{
	private $_pdo = NULL;

	
	function getName(){
		return "pdo";
	}

	
	function open($connectionString){
		if ($this->_pdo != NULL)
			return false;

		try{
			$this->_pdo = new \PDO($connectionString);
		}catch( \PDOException $e ){
			return false;
		}
		
		return true;
	}

	
	function close(){
		$this->_pdo = NULL;

		return true;
	}

	
	function escape($string){
		return $this->_pdo->quote($string);
	}

	
	function query($sql, $primaryKey=NULL){
		$result = $this->_pdo->query($sql);

		if ($result === false)
			return false;

		$lastID = $this->_pdo->lastInsertId();

		return new PDOResult($result, $primaryKey, $lastID);
	}
}

