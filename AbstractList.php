<?
namespace pfc;

/**
 * AbstractList
 *
 */
interface AbstractList extends \arrayaccess, Addable, Iterable{
	/**
	 * removes all list elements
	 * 
	 */
	function clear();
}

