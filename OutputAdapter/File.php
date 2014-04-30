<?
namespace pfc\OutputAdapter;

use pfc\OutputAdapter;
use pfc\UnitTest;

/**
 * File OutputAdapter
 *
 * supports "writting" to specific file, using standard PHP fopen()
 *
 */
class File implements OutputAdapter, UnitTest{
	private $_file;

	/**
	 * Constructor
	 *
	 * @param resource $file file object as returned from fopen() or STDOUT / STDERR
	 *
	 */
	function __construct($file){
		$this->_file = $file;
	}


	function write($line, $cr = true){
		if ($cr)
			$line = $line . "\n";

		fwrite($this->_file, $line);
	}


	static function test(){
		$adapter = new File(STDOUT);
		$adapter->write("OutputAdapter::File::Testing...");
	}
}

