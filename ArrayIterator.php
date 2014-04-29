<?
namespace pfc;

/**
 * Iterator over array
 *
 */
class ArrayIterator implements Iterator, Countable, UnitTest{
	private $_array;
	private $_keys;
	
	private $_pos;


	/**
	 * constructor
	 * 
	 * @param array $array array to be iterated over
	 * @param string $preserve_keys preserve keys of the array
	 */
	function __construct(array $array, $preserve_keys = true){
		if (! is_array($array))
			$array = array();

		$this->_array = array_values($array);
		
		if ($preserve_keys)
			$this->_keys = array_keys($array);
		else
			$this->_keys = false;
		
		$this->_pos = -1;
	}


	function count(){
		return count($this->_array);
	}

	
	function isEmpty(){
		return $this->count() == 0;
	}


	function rewind(){
		$this->_pos = -1;
	}

	
	function next(){
		$this->_pos++;
		return $this->_pos < count($this->_array);
	}

	
	function current(){
		return $this->_array[$this->_pos];
	}

	
	function currentKey(){
		if ($this->_keys)
			return $this->_keys[$this->_pos];
			
		return NULL;
	}


	static function test(){
		$a = range(0, 100 - 1);

		$x = new ArrayIterator($a);

		$i = 0;
		while($x->next()){
			assert($x->current() == $i);
			$i++;
		}

		assert($i == 100);
		
		
		
		$x = new ArrayIterator(array(
			"a0" => 1,
			"a1" => 2
		));

		$i = 0;
		while($x->next()){
			assert($x->currentKey() == "a" . $i);
			$i++;
		}
		
		
		
		$x = new ArrayIterator(array(
			"a0" => 1,
			"a1" => 2
		), false);

		$i = 0;
		while($x->next()){
			assert($x->currentKey() == NULL);
			$i++;
		}
	}
}

