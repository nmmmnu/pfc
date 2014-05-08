<?
namespace pfc\OutputAdapter;

use pfc\OutputAdapter;

/**
 * PHP original error_log OutputAdapter
 *
 * supports "writting" to /dev/null
 *
 */
class PHP implements OutputAdapter{
	private static $SUPRESSED_TYPES = array(1,2,3);
	
	private $_message_type;

	/**
	 * Constructor
	 *
	 * @param int $message_type error_log() message_type
	 * 
	 * 0 = message is sent to PHP's system logger
	 * 1 = suppressed
	 * 2 = suppressed
	 * 3 = suppressed
	 * 4 = message is sent directly to the SAPI logging handler
	 *
	 */
	function __construct($message_type = 0){
		if (in_array($message_type, self::$SUPRESSED_TYPES ))
			$message_type = 0;
		
		$this->_message_type = $message_type;
	}

	function write($line, $cr = true){
		if ($cr)
			$line = $line . "\n";

		error_log($line, $this->_message_type);
	}
	
	
	static function test(){
		$adapter = new PHP();
		$adapter->write("OutputAdapter::PHP::Testing...");
	}
}

