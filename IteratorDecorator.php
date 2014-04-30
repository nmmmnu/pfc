<?
namespace pfc;

/**
 * Iterator over the keys of another iterator
 *
 */
class IteratorDecorator implements \Iterator, UnitTest{
	private $_iterator;


	/**
	 * constructor
	 *
	 * @param Iterator $iterator
	 *
	 */
	function __construct(\Iterator $iterator){
		$this->_iterator = $iterator;
	}

	// =============================

	function rewind(){
		return $this->_iterator->rewind();
	}


	function current(){
		return $this->_iterator->current();
	}


	function key(){
		return $this->_iterator->key();
	}


	function next(){
		return $this->_iterator->next();
	}


	function valid(){
		return $this->_iterator->valid();
	}

	// =============================

	static function test(){
		$a = array(
			"a" => 1,
			"b" => 1,
			"c" => 1
		);

		$it  = new \ArrayIterator($a);
		$kit = new IteratorDecorator($it);

		while($kit->valid()){
			assert($it->current() == $kit->current());
			$kit->next();
		}
	}
}

