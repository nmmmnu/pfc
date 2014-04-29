<?
namespace pfc;

/**
 * Countable
 * 
 */
interface Countable{
	/**
	 * check if count() == 0
	 *
	 * @return boolean
	 */
	function isEmpty();
	
	
	/**
	 * get count of the elements
	 *
	 * @return Iterator
	 */
	function count();
}

