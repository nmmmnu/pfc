<?
namespace pfc\compat;

use pfc\UnitTest;
use pfc\Iterator;

/**
 * Adapter that converts PHP original Iterator to Iterator
 * 
 */
class PHP2Iterator implements Iterator, UnitTest{
	private $_iterator;
	private $_valueKey;
	private $_value;


	/**
	 * constructor
	 * 
	 * @param \Iterator $iterator PHP original Iterator to be converted
	 */
	function __construct(\Iterator $iterator){
		$this->_iterator = $iterator;
	}

	
	function rewind(){
		$this->_iterator->rewind();
	}

	
	function next(){
		if ($this->_iterator->valid() == false)
			return false;

		$this->_valueKey = $this->_iterator->key();
		$this->_value    = $this->_iterator->current();

		$this->_iterator->next();

		return true;
	}

	
	function current(){
		return $this->_value;
	}
	

	function currentKey(){
		return $this->_valueKey;
	}
	

	static function test(){
		$a = range(0, 100 - 1);

		$originalIterator = new \ArrayIterator($a);

		$x = new PHP2Iterator($originalIterator);

		$i = 0;
		while($x->next()){
			assert($x->current() == $i);
			$i++;
		}

		assert($i == 100);

	}
}

