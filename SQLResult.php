<?
namespace pfc;

/**
 * SQLResult Iterator
 *
 */
interface SQLResult extends \Iterator{
	/**
	 * get affected rows (count of the array)
	 *
	 * @return int
	 */
	function affectedRows();


	/**
	 * get last insert id
	 *
	 * @return int
	 */
	function insertID();
}

