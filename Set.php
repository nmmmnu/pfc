<?
namespace pfc;

/**
 * Set
 *
 */
class Set implements AbstractSet, Iterable, UnitTest{
	private $_list;


	/**
	 * constructor
	 *
	 * @param AbstractList $list list for store the data
	 */
	function __construct(AbstractList $list){
		$this->_list = $list;
		$this->clear();
	}


	function iterator(){
		return new KeysIteratorDecorator( $this->_list->iterator() );
	}


	function count(){
		return Iterators::countAll( $this->iterator() );
	}
	
	
	function isEmpty(){
		return $this->count() == 0;
	}


	/**
	 * removes all elements from the Set
	 *
	 */
	function clear(){
		$this->_list->clear();
	}


	function contains($obj){
		return $this->_list[$obj] == 1;
	}


	function add($obj){
		$this->_list[$obj] = 1;
	}


	function del($obj){
		unset($this->_list[$obj]);
	}


	static function test(){
		$x = new Set( new ArrayList() );

		Iterators::addArray($x, range(0, 100 - 1) );

		$x->add(500);
		$x->add(501);
		$x->del(50);

		assert($x->contains(1) == true);
		assert($x->contains(500) == true);

		assert($x->contains(50) == false);
		assert($x->contains(1000) == false);



		$x->clear();

		assert($x->contains(1) == false);



		Iterators::addAll($x, new ArrayIterator( range(0, 100 - 1) ) );

		assert($x->count() == 100);



		$x->add(500);
		$x->add(501);
		$x->del(50);

		assert($x->contains(1) == true);
		assert($x->contains(500) == true);

		assert($x->contains(50) == false);
		assert($x->contains(1000) == false);
	}
}

