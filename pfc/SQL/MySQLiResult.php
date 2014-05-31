<?
namespace pfc\SQL;

use pfc\SQLIntermediateResult;


/**
 * MySQLi adapter for SQLIntermediateResult
 *
 */
class MySQLiResult implements SQLIntermediateResult{
	private $_results;
	

	function __construct($results){
		$this->_results    = $results;
		$this->_primaryKey = $primaryKey;
	}


	function affectedRows(){
		return $this->_results->num_rows;
	}


	function insertID(){
		return 0;
	}


	function fetch(){
		$data = $this->_results->fetch_assoc();
		
		if (!$data)
			return null;
		
		return $data;
	}
}

