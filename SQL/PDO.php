<?
namespace pfc\SQL;

use pfc\SQL;
use pfc\SQLTools;


/**
 * PDO adapter
 *
 * query always returns the array passed by constructor
 *
 */
class PDO implements SQL{
	private $_pdo;
	private $_connection;


	function __construct(array $connection = array()){
		$this->_connection = $connection;
		$this->_pdo = null;
	}


	function getName(){
		return "pdo";
	}


	function getParamsHelp(){
		return array(
			"connection_string",
			"user",
			"password"
		);
	}


	function open(){
		if ($this->_pdo)
			return true;

		try{
			$this->_pdo = new \PDO(
				@$this->_connection["connection_string"],
				@$this->_connection["user"],
				@$this->_connection["password"]
			);
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


	function query($sql, array $params, $primaryKey = null){
		$sql = SQLTools::escapeQuery($this, $sql, $params);

		$result = $this->_pdo->query($sql);

		if ($result === false)
			return false;

		$lastID = $this->_pdo->lastInsertId();

		return new PDOResult($result, $primaryKey, $lastID);
	}
}

