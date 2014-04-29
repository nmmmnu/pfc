<?
namespace pfc;

/**
 * AbstractSet
 *
 */
interface AbstractSet extends Container, Countable, Addable{
	/**
	 * removes an element from the set
	 * 
	 * @param mixed $obj
	 */
	function del($obj);
	
	
	/**
	 * removes all elements from the set
	 * 
	 */
	function clear();
}

