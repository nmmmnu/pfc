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
class MySQLi implements SQL{
	private $_link;
	private $_connection;


	function __construct(array $connection = array()){
		$this->_connection = $connection;
		$this->_link = null;
	}


	function getName(){
		return "mysqli";
	}


	function getParamsHelp(){
		return array(
			"host",
			"port",
			"database",
			"user",
			"password",
			"socket",

			"init_command"
		);
	}


	function open(){
		if ($this->_link)
			return true;

		/*
		// not seems to be true
		if (@$this->_connection["socket"])
			@$this->_connection["host"] = ".";
		*/

		$this->_link = new \mysqli(
			@$this->_connection["host"],
			@$this->_connection["user"],
			@$this->_connection["password"],
			@$this->_connection["database"],
			@$this->_connection["port"],
			@$this->_connection["socket"]
		);

		if ($this->_link->connect_error){
			$this->_link = null;
			return false;
		}

		if (@$this->_connection["init_command"])
			$this->query(@$this->_connection["init_command"]);

		return true;
	}


	function close(){
		$this->_link->close();

		return true;
	}


	function escape($string){
		return sprintf("'%s'", $this->_link->real_escape_string($string));
	}


	function query($sql, array $params, $primaryKey = null){
		$sql = SQLTools::escapeQuery($this, $sql, $params);

		$result = $this->_link->query($sql);

		if ($result === false)
			return false;

		if ($result === true){
			// query with no results

			return new IteratorResult(
				new \EmptyIterator(),
				$primaryKey,
				$this->_link->affected_rows,
				$this->_link->insert_id
			);
		}

		var_dump($result);

		// result set
		return new MySQLiResult($result, $primaryKey, $lastID);
	}
}

