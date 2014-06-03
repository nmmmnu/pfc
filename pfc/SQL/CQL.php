<?
namespace pfc\SQL;

use pfc\SQL,
	pfc\SQLResult;


/**
 * CQL adapter using cassandra via thrift
 *
 */
class CQL implements SQL{
	use TraitEscape;


	const CQL_COMPRESSION = 2;


	private $_connection;


	private $_transport = null;
	private $_client = null;


	function __construct(array $connection = array()){
		$this->_connection = $connection;
	}


	function getName(){
		return "cql";
	}


	function getParamsHelp(){
		return array(
			"hosts"		,
			"keyspace"	,
			"primary_key"
		);
	}


	function open(){
		if ($this->_client)
			return true;

		$hosts    = $this->_connection["hosts"];
		$keyspace = $this->_connection["keyspace"];

		shuffle($hosts);

		foreach($hosts as $host_port){
			list($host, $port) = explode(":", $host_port);

			if ($this->connect($host, $port, $keyspace))
				return true;
		}

		return false;
	}


	private function connect($host, $port, $keyspace){
		try{
			$socket = new \Thrift\Transport\TSocket($host, $port);

			$this->_transport = new \Thrift\Transport\TFramedTransport($socket, true, true);

			$this->_client = new \cassandra\CassandraClient(new \Thrift\Protocol\TBinaryProtocolAccelerated($this->_transport));

			$this->_transport->open();

			$this->_client->set_keyspace($keyspace);

			return true;

		}catch(\Exception $e){
			return false;
		}
	}


	function close(){
		try{
			$this->_transport->close();
		}catch(\Exception $e){
			// Who cares :)
		}

		return true;
	}


	function escape($string){
		return str_replace("'", "''", $string);
	}


	function query($sql, array $params, $primaryKey = null){
		$this->open();

		$sql = $this->escapeQuery($sql, $params);


		try{
			$result = $this->_client->execute_cql_query($sql, self::CQL_COMPRESSION);
		}catch(\Exception $e){
			return false;
		}


		// select
		if (is_array($result->rows)){
			$array = $this->transformCassandraResults($result);

			return new SQLResult(
				new ArrayResult($array),
				$primaryKey);
		}


		// insert, update, delete
		return new SQLResult(
			new EmptyResult(),
			$primaryKey);
	}


	private function transformCassandraResults($data){
		$array = array();

		foreach($data->rows as $r){
			$row = array();

			// add the key
			if (isset($this->_connection["primary_key"]))
				$row[ $this->_connection["primary_key"] ] = $r->key;

			// add the columns
			foreach($r->columns as $column)
				if ($column->name && $column->value)
					$row[$column->name] = $column->value;

			$array[] = $row;
		}

		return $array;
	}
}

