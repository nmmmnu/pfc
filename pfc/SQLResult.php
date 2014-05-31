<?
namespace pfc;


/**
 * Adapter that converts SQLIntermediateResult to SQLResult
 *
 */
class SQLResult implements \Iterator{
	private $_result;

	private $_primaryKey;

	private $_row;
	private $_rowID;


	/**
	 * constructor
	 *
	 * @param Iterator $iterator iterator with the row data
	 * @param string $primaryKey "primary key" for the array keys
	 * @param int $affectedRows affected rows value for affectedRows()
	 * @param int $insertID last insert id for insertID()
	 */
	function __construct(SQLIntermediateResult $result, $primaryKey = false){
		$this->_result		= $result;

		$this->_primaryKey	= $primaryKey;

		$this->_rowID		= 0;
	}


	function affectedRows(){
		return $this->_result->affectedRows();
	}


	function insertID(){
		return $this->_result->insertID();
	}


	// =============================


	function get($field = false){
		foreach($this as $result){
			if ($field)
				return $result[$field];

			return $result;
		}

		return false;
	}


	function getArray($keys = true){
		return iterator_to_array($this, $keys);
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
			return $this->_rowID - 1;

		if ( isset($this->_row[$this->_primaryKey] ))
			return $this->_row[$this->_primaryKey];
	}


	function next(){
		$this->_rowID++;
		$this->_row = $this->_result->fetch();
	}


	function valid(){
		if ($this->_rowID == 0)
			return true;

		return $this->_row !== null;
	}	
}

