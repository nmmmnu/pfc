<?
namespace pfc\ErrorHandler;

require_once __DIR__ . "/../__autoload.php";

use pfc\ErrorHandler;

class Development extends ErrorHandler{
	function __construct($html = true){
		parent::__construct($html);
	}


	function handler($errno, $errstr, $errfile, $errline, $errcontext){
		$br = $this->_html ? "<br />" : "";

		printf("$br\n");

		printf("PHP %s [%s] %s $br\n", $this->getErrorType($errno), $errno, $errstr);
		printf("   on line %d in file %s $br\n", $errline, $errfile);
		printf("System: $br\n");
		printf("   PHP %s (%s) $br\n", PHP_VERSION, PHP_OS);

		printf("Print stack: $br\n");

		echo $this->printStackTrace();

		if (in_array($errno, array(E_ERROR, E_USER_ERROR) ) )
			exit(1);

		return true;
	}
}


