<?
namespace pfc;

/**
 * ArrayList
 *
 * List using array, used mostly for tests
 *
 */
class ArrayList implements \ArrayAccess, \Countable, \IteratorAggregate, Addable {
	private $_data = array();

	/**
	 * constructor
	 *
	 * @param array $data arrays with initial elements
	 */
	function __construct(array $data = array()) {
		$this->_data = $data;
	}

	function clear(){
		$this->_data = array();
	}

	function addArray(array $array, $merge = false){
		if ($merge == false){
			$this->_data = array();
			return;
		}

		foreach($array as $key => $val)
			$this[$key] = $val;
	}

	/* Magic functions */

	function offsetSet($offset, $value) {
		if (is_null($offset)) {
			$this->_data[] = $value;
		} else {
			$this->_data[$offset] = $value;
		}
	}


	function offsetExists($offset) {
		return isset($this->_data[$offset]);
	}


	function offsetUnset($offset) {
		unset($this->_data[$offset]);
	}


	function offsetGet($offset) {
		if (isset($this->_data[$offset]))
			return $this->_data[$offset];

		return null;
	}

	/* addable functions */

	function add($value){
		$this->offsetSet(null, $value);
	}

	/* countable functions */

	function count(){
		return count($this->_data);
	}


	function isEmpty(){
		return $this->count() == 0;
	}

	/* iterator functions */

	function getIterator(){
		return new \ArrayIterator($this->_data);
	}

	/* tests */

	static function test(){
		$max = 100;

		$x = new ArrayList();

		foreach(range(0, $max - 1) as $a)
			$x[] = $a;

		assert($x->count() == $max);

		$x[5] = 1000;
		unset($x[10]);

		assert($x[1] == 1);
		assert($x[5] == 1000);
		assert($x[10] == null);
	}
}
