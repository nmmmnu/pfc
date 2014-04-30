<?
namespace pfc\LoggerFormat;

use pfc\LoggerFormat;

/**
 * Add static string
 *
 * decorate a string for logging purposes
 *
 */
class String implements LoggerFormat{
	private $_string;


	/**
	 * constructor
	 *
	 * @param string $string string to be added
	 *
	 */
	function __construct($string){
		$this->_string = $string;
	}


	function format($message){
		return $this->_string . self::SEPARATOR . $message;
	}
}


