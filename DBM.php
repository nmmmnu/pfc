<?
namespace pfc;

/**
 * DBM adapter
 *
 */
class DBM implements AbstractList, UnitTest{
//	const   DEFAULT_DBM_TYPE = "cdbm";
	const   DEFAULT_DBM_TYPE = "gdbm";

	const   MODE_READ   = "rl";
	const   MODE_WRITE  = "cl";
	const   MODE_NEW    = "nl";

	private $_dbm;
	private $_filename;
	private $_dbmtype;
	private $_alreadyOpen = false;

	private $uniqidPrefix = "TMP_";

	/**
	 * constructor
	 * 
	 * @param string $filename path to DBM file
	 * @param string $mode DBM open mode
	 * @param string $dbmtype DBM type
	 */
	function __construct( $filename, $mode = DBM::MODE_WRITE, $dbmtype = DBM::DEFAULT_DBM_TYPE){
		$this->_filename = $filename;
		$this->_dbmtype  = $dbmtype;

		$this->openDBM($mode);
	}

	
	private function openDBM($mode){
		if ($this->_alreadyOpen)
			dba_close($this->dbm);

		$this->_alreadyOpen = true;

		$this->dbm = @dba_open($this->_filename, $mode, $this->_dbmtype);
	}

	/* Magic functions */

	function offsetSet($offset, $value) {
		if (is_null($offset)) {
			$offset = uniqid($this->uniqidPrefix);
		}

		dba_replace($offset, $value, $this->dbm);
	}

	function offsetExists($offset) {
		if ($this->offsetGet($offset))
			return true;

		return false;
	}

	function offsetUnset($offset) {
		dba_delete($offset, $this->dbm);
	}

	function offsetGet($offset) {
		$value = dba_fetch($offset, $this->dbm);

		if ($value === false)
			return NULL;

		return $value;
	}

	/* addable functions */

	function add($value){
		$this->offsetSet(NULL, $value);
	}

	/* iterator functions */

	function clear(){
		$this->openDBM(DBM::MODE_NEW);
	}


	function iterator(){
		return new DBMIterator($this->dbm);
	}

	/* tests */

	static function test(){
		$x = new DBM("/dev/shm/test.db", DBM::MODE_NEW);

		foreach(range(0, 100 - 1) as $a)
			$x[$a] = $a;

		foreach(range(0, 100 - 1) as $a)
			$x[] = $a . "temp";

		//assert($x->count() == 100);

		$x[5] = 1000;
		unset($x[10]);

		assert($x[1] == 1);
		assert($x[5] == 1000);
		assert($x[10] == null);
	}
}

