<?
namespace pfc;

/**
 * class similar to Google's Java Iterators
 *
 */
final class Iterators{
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
	static function addAll(Addable $list, \Iterator $iterator ){
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


	/**
	 * get Unique ID for the array
	 *
	 * @param Iterator $iterator
	 */
	static function arrayUniqID(array $array){
		ksort($array);
		return md5(serialize($array));
	}


	static function test(){
		$array = range(0, 100);
		$array2 = Iterators::toArray(new \ArrayIterator($array));
		assert(count($array2) == count($array));
		assert($array2[5] == $array[5]);
		assert($array2 == $array);

		// ============================

		$list = new ArrayList();
		Iterators::addAll($list, new \ArrayIterator($array));
		assert($list->count() == count($array));
		assert($list[5] == $array[5]);

		// ============================


		$list = new ArrayList();
		Iterators::addArray($list, $array);
		assert($list->count() == count($array));
		assert($list[5] == $array[5]);

		// ============================

		$count = Iterators::countAll(new \ArrayIterator($array));
		assert($count == count($array));

		// ============================

		$iterator = new \ArrayIterator(array(
			"a" => 1,
			"b" => 2,
			"c" => 3
		));

		echo "You should see Iterators::dumpAll() result:\n";
		Iterators::dumpAll($iterator);

		// ============================

		$a1 = array("host" => "localhost", "user" => "admin");
		$a2 = array("user" => "admin", "host" => "localhost");
		$a3 = array("user" => "system", "host" => "localhost");

		assert(Iterators::arrayUniqID($a1) == Iterators::arrayUniqID($a2));
		assert(Iterators::arrayUniqID($a1) != Iterators::arrayUniqID($a3));
	}
}

