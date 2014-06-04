<?
namespace pfc\ErrorHandler;


class Development extends ErrorHandler{
	function __construct($html = true, $suppress = true){
		parent::__construct($html, $suppress);
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
	}


	function supressed_msg(){
		printf("***** suppressed error *****\n");
	}
}


