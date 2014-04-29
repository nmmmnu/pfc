<?
namespace pfc\OutputAdapter;

use pfc\OutputAdapter;

/**
 * NULL OutputAdapter
 *
 * supports "writting" to /dev/null
 *
 */
class NULLAdapter implements OutputAdapter{
	function write($line, $cr = true){
	}
}

