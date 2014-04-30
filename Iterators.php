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
	static function toArray(\Iterator $iterator){
		return iterator_to_array($iterator);
	}


	/**
	 * add all elements from an Iterator to the Addable
	 *
	 * @param Addable $list
	 * @param Iterator $iterator
	 */
	static function addAll(Addable $list, Iterator $iterator ){
		foreach($iterator as $element)
			$list->add($element);
	}


	/**
	 * add all elements from an array to the Addable
	 *
	 * @param Addable $list
	 * @param array $array
	 */
	static function addArray(Addable $list, array $array ){
		foreach($array as $element)
			$list->add($element);
	}


	/**
	 * count all elements in an Iterator
	 *
	 * @param Iterator $iterator
	 * @return int
	 */
	static function countAll(\Iterator $iterator){
		if ($iterator instanceof \Countable)
			return $iterator->count();

		return iterator_count($iterator);
	}


	/**
	 * dump all elements from an Iterator for debugging purposes
	 *
	 * @param Iterator $iterator
	 */
	static function dumpAll(\Iterator $iterator){
		$i = 0;

		foreach($iterator as $key => $value){
			printf("%4d | %10s | %s\n", $i, $key, $value);

			$i++;
		}
	}


	static function test(){

		$sb1 = new StringBuilder();

		$array = range(0, 100);

		foreach($array as $a)
			$sb1->add($a);

		$sb2 = new StringBuilder();

		Iterators::addArray($sb2, $array);

		assert($sb1 == $sb2);

		// ============================

		$array2 = Iterators::toArray(new \ArrayIterator($array));
		assert(count($array2) == count($array));

		// ============================

		$iterator = new \ArrayIterator(array(
			"a" => 1,
			"b" => 2,
			"c" => 3
		));

		echo "You should see Iterators::dumpAll() result:\n";
		Iterators::dumpAll($iterator);

		// ============================

		$array3 = Iterators::toArray($iterator);

		assert(count($array3["a"]) == 1);
	}
}

