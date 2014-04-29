<?
namespace pfc;

/**
 * ArrayList
 * 
 * AbstractList using array
 *
 */
class ArrayList implements AbstractList, Countable, Container, UnitTest {
	private $_data = array();

	/**
	 * constructor
	 *
	 * @param array $data arrays with initial elements
	 */
	function __construct(array $data = array()) {
		$this->_data = $data;
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

		return NULL;
	}

	/* addable functions */

	function add($value){
		$this->offsetSet(NULL, $value);
	}

	/* container functions */

	function contains($obj){
		return in_array($obj, $this->_data);
	}

	/* countable functions */

	function count(){
		return count($this->_data);
	}
	

	function isEmpty(){
		return $this->count() == 0;
	}

	/* iterator functions */

	function clear(){
		$this->_data = array();
	}

	function iterator(){
		return new ArrayIterator($this->_data);
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
