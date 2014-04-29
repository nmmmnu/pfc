<?
namespace pfc;

/**
 * class similar to Google's Java Iterators
 *
 */
class Iterators implements UnitTest{
	private function __construct(){
	}


	/**
	 * convert an Iterator to array
	 *
	 * @param Iterator $iterator
	 * @return array
	 */
	static function toArray(Iterator $iterator){
		$array = array();

		$iterator->rewind();

		while($iterator->next()){
			$key = $iterator->currentKey();
			$val = $iterator->current();
			
			if ($key)
				$array[$key] = $val;
			else
				$array[]     = $val;
		}
		
		return $array;
	}


	/**
	 * add all elements from an Iterator to the Addable
	 *
	 * @param Addable $list
	 * @param Iterator $iterator
	 */
	static function addAll(Addable $list, Iterator $iterator ){
		$iterator->rewind();

		while($iterator->next())
			$list->add($iterator->current());
	}


	/**
	 * add all elements from an array to the Addable
	 *
	 * @param Iterator $iterator
	 * @param array $array
	 */
	static function addArray(Addable $list, array $array ){
		if (! is_array($array))
			return;

		foreach($array as $obj)
			$list->add($obj);
	}
	

	/**
	 * count all elements in an Iterator
	 *
	 * @param Iterator $iterator
	 * @return int
	 */
	static function countAll(Iterator $iterator ){
		if ($iterator instanceof Countable)
			return $iterator->count();
		
		$iterator->rewind();

		$count = 0;

		while($iterator->next()){
			$dummy = $iterator->current();
			$count++;
		}

		return $count;
	}
	

	/**
	 * dump all elements from an Iterator for debugging purposes
	 *
	 * @param Iterator $iterator
	 */
	static function dumpAll(Iterator $iterator ){
		$iterator->rewind();
		
		$i = 0;
		
		while($iterator->next()){
			printf("\t%4d | %-20s = %s\n",
				$i,
				$iterator->currentKey(),
				$iterator->current()
			);
			
			$i++;
		}
	}


	static function test(){
		$x = new ArrayList();

		foreach(range(0, 100 - 1) as $a)
			$x->add($a);

		$y = new ArrayList();

		Iterators::addAll($y, $x->iterator());

		assert($x->count() == $y->count());

		assert($x->count() == Iterators::countAll($y->iterator()));



		$x = range(0, 100 - 1);

		$y = new ArrayList();

		Iterators::addArray($y, $x);

		assert(count($x) == $y->count());

		assert(count($x) == Iterators::countAll($y->iterator()));



		$z = Iterators::toArray(new ArrayIterator(range(0, 100 - 1)));
		assert(count($z) == 100);
		
		$it = new ArrayIterator(array(
			"a" => 1,
			"b" => 2
		));
		
		echo "You should see Iterators::dumpAll() result:\n";
		Iterators::dumpAll($it);
		
		$z = Iterators::toArray($it);
		
		assert(count($z["a"]) == 1);
	}
}

