<?
namespace pfc\OutputAdapter;

/**
 * OutputAdapter
 *
 * Useful for text output and logging
 *
 */
interface OutputAdapter{
	/**
	 * write string to the StreamAdapter
	 *
	 * @param string $s string to be written
	 */
	function write($line, $cr = true);
}

