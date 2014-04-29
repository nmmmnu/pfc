<?
namespace pfc;

/**
 * Iterator
 * 
 * Similar to original PHP Iterator, but much simpler
 * Does *not* work with foreach, you need to do:
 * 
 * while($iterator->next()){
 *    echo $iterator->current();
 *    echo "\n";
 * }
 *
 */
interface Iterator{
	/**
	 * restart the iterator
	 *
	 */
	function rewind();


	/**
	 * go to next element
	 *
	 * @return boolean
	 */
	function next();


	/**
	 * get the element
	 *
	 * @return mixed
	 */
	function current();


	/**
	 * get the key
	 *
	 * @return mixed
	 */
	function currentKey();	
}

