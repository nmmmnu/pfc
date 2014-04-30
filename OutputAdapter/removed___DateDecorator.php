<?
namespace pfc\OutputAdapter;

use pfc\OutputAdapter;
use pfc\UnitTest;

/**
 * Decorator that adds date-time to any OutputAdapter
 *
 * supports "writting" to /dev/null
 *
 */
class DateDecorator implements OutputAdapter, UnitTest{
	const   YYYYMMDDHHMMSS     = "%Y-%m-%d %H:%M:%S ";
	const   YYYYMMDDHHMMSS_NUM = "%Y%m%d%H%M%S ";

	private $_outputAdapter;
	private $_strftime;

	/**
	 * constructor
	 *
	 * @param OutputAdapter $outputAdapter
	 *
	 */
	function __construct(OutputAdapter $outputAdapter, $strftime = self::YYYYMMDDHHMMSS){
		$this->_outputAdapter = $outputAdapter;
		$this->_strftime = $strftime;
	}

	
	function write($line, $cr = true){
		$date = strftime($this->_strftime);
		$this->_outputAdapter->write($date . $line, $cr);
	}


	static function test(){
		$ca = new Console();
		$da = new DateDecorator($ca);
		$da->write("DateDecorator::Testing...");
	}
}

