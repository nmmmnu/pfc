<?
namespace pfc\ErrorHandler;

require_once __DIR__ . "/../__autoload.php";

use pfc\ErrorHandler;

class Development extends ErrorHandler{
	private $_html;

	function __construct($html = true){
		$this->_html = $html;
	}

	function handler($errno, $errstr, $errfile, $errline, $errcontext){
		$br = $this->_html ? "<br>" : "";

		printf("PHP %s [%s] %s $br\n", self::getErrorType($errno), $errno, $errstr);
		printf("   on line %d in file %s $br\n", $errline, $errfile);
		printf("System: $br\n");
		printf("   PHP %s (%s) $br\n", PHP_VERSION, PHP_OS);

		printf("Print stack: $br\n");

		$i = 0;
		$first = true;
		foreach(debug_backtrace() as $line){
			if ($first){
				$first = false;
				continue;
			}

			$args = "";
			foreach($line["args"] as $arg){
				if ($args == "")
					$args .= sprintf("'%s'", $arg);
				else
					$args .= sprintf(", '%s'", $arg);
			}

			printf("%4d %-20s(%d) %s(%s) $br\n",
				$i,
				$line["file"],
				$line["line"],
				$line["function"],
				$args
			);

			$i++;
		}

		if ($errno == E_USER_ERROR)
			exit(1);

		return true;
	}
}


Development::register(new Development(false));

function bla($s, $a){
	$x = array() . 5;
}

bla("niki", array(12) );


