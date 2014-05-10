<?
namespace pfc\ErrorHandler;

require_once __DIR__ . "/../__autoload.php";

use pfc\ErrorHandler;

class Production extends ErrorHandler{
	function __construct($html = true, $suppress = false){
		parent::__construct($html, $suppress);
	}


	function handler($errno, $errstr, $errfile, $errline, $errcontext){
		$br =  $this->_html ? "<br />" : "";

		if (in_array($errno, array(E_ERROR, E_USER_ERROR) ) ){
			printf("$br\n");

			printf("Error! $br\n");
		}
	}


	function supressed_msg(){
		// empty
	}
}


