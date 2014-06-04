<?
namespace pfc\LoggerFormat;


/**
 * Add Date / Time information
 *
 * decorate a string for logging purposes
 *
 */
class Date implements LoggerFormat{
	const   YYYYMMDDHHMMSS     = "%Y-%m-%d %H:%M:%S";
	const   YYYYMMDDHHMMSS_NUM = "%Y%m%d%H%M%S";


	private $_strftime;


	/**
	 * constructor
	 *
	 * @param string $strftime strftime() format string
	 *
	 */
	function __construct($strftime = self::YYYYMMDDHHMMSS){
		$this->_strftime = $strftime;
	}


	function format($message){
		$date = strftime($this->_strftime);

		return $date . self::SEPARATOR . $message;
	}
}


