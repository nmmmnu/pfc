<?
namespace pfc;

/**
 * Iterator over the keys of another iterator
 *
 */
class KeysIteratorDecorator implements Iterator, UnitTest{
	private $_iterator;


	/**
	 * constructor
	 * 
	 * @param Iterator $iterator
	 *
	 */
	function __construct(Iterator $iterator){
		$this->_iterator = $iterator;
	}


	function rewind(){
		$this->_iterator->rewind();
	}


	function next(){
		return $this->_iterator->next();
	}


	function current(){
		return $this->_iterator->currentKey();
	}


	function currentKey(){
		return $this->_iterator->currentKey();
	}


	static function test(){
		$a = array(
			"a" => 1,
			"b" => 1,
			"c" => 1
		);

		$it  = new ArrayIterator($a);
		$kit = new KeysIteratorDecorator($it);

		while($kit->next()){
			assert($it->currentKey() == $kit->current());
		}
	}
}

