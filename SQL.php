<?
namespace pfc;

/**
 * Abstract SQL adapter
 *
 */
interface SQL{
	/**
	 * return the adapter name
	 *
	 * @return string
	 */
	function getName();


	/**
	 * open database connection
	 *
	 * @param string connectionString connection string
	 * @return boolean
	 */
	function open($connectionString);


	/**
	 * close database connection
	 *
	 * @return boolean
	 */
	function close();


	/**
	 * escape the string for use in sql statements
	 *
	 * @param string $string string to be escaped
	 * @return string
	 */
	function escape($string);


	/**
	 * query the database
	 *
	 * @param string $sql SQL statement
	 * @param string $primaryKey "primary key" to be used later with the iterators
	 * @return SQLResult
	 */
	function query($sql, $primaryKey=NULL);
}

