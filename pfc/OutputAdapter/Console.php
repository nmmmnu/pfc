<?
namespace pfc\OutputAdapter;

use pfc\OutputAdapter;

/**
 * Console StreamAdapter
 *
 * supports "writting" to Console (STDERR)
 *
 */
 class Console implements OutputAdapter{
	function write($line, $cr = true){
		if ($cr)
			$line = $line . "\n";

		echo $line;
	}


	static function test(){
		$adapter = new self;
		$adapter->write("OutputAdapter::Console::Testing...");
	}
}

