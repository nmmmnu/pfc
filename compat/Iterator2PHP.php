<?
namespace pfc\compat;

use pfc\UnitTest;
use pfc\Iterator;

/**
 * Adapter that converts Iterator to PHP original Iterator 
 *
 */
class Iterator2PHP implements \Iterator, UnitTest{
	private $iterator;
	private $key;
	private $val;


	/**
	 * constructor
	 * 
	 * @param Iterator $iterator Iterator to be converted
	 * 
	 */
	function __construct(Iterator $iterator){
		$this->iterator = $iterator;
		$this->key = NULL;
		$this->val = true;
	}


	function rewind(){
		$this->iterator->rewind();
		$this->val = $this->iterator->next();
		$this->pos = 0;
	}
	

	function current(){
		return $this->iterator->current();
	}
	

	function key(){
		return $this->iterator->currentKey();
	}

	
	function next(){
		$this->val = $this->iterator->next();
	}

	
	function valid(){
		return $this->val ? true : false;
	}


	static function test(){
		$a = range(0, 100 - 1);

		$ai = new \pfc\ArrayIterator($a, false);

		$iterator = new Iterator2PHP($ai);

		$i = 0;
		foreach($iterator as $x){
			assert($x == $i);
			$i++;
		}

		assert($i == 100);
	}
}

