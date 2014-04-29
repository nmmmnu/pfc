<?
namespace pfc;

/**
 * Iterator over DBM adapter
 *
 */
class DBMIterator implements Iterator, UnitTest{
	private $_dbm;
	private $_pos;
	private $_firstPos;

	/**
	 * constructor
	 * 
	 * @param resource $dbm dbm handle
	 */
	function __construct($dbm){
		$this->_dbm = $dbm;

		$this->rewind();
	}


	function rewind(){
		$this->_firstPos = true;
	}
	

	function next(){
		if ($this->_firstPos){
			// Fetch first key
			$this->_pos = dba_firstkey($this->_dbm);
			$this->_firstPos = false;
		}else{
			// Fetch next key
			$this->_pos = dba_nextkey($this->_dbm);
		}

		return $this->_pos !== false;
	}
	

	function current(){
		return dba_fetch($this->_pos, $this->_dbm);
	}

	
	function currentKey(){
		return $this->_pos;
	}


	static function test(){
		$max = 15;

		$x = new DBM("/dev/shm/test.db", DBM::MODE_NEW);

		foreach(range(0, $max - 1) as $a)
			$x->add($a);



		$y = $x->iterator();


		echo "You should see $max hashes with their values now:\n";

		$i = 0;
		while($y->next()){
			$k = $y->currentKey();
			$v = $y->current();

			printf("\t%4d | %-20s = %2s\n", $i, $k, $v);

			$i++;
		}

		assert($i == $max);
	}
}

