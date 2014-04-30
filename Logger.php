<?
namespace pfc;

class Logger{
	const OFF     = 0;
	const ERROR   = 1;
	const WARNING = 2;
	const INFO    = 3;
	const DEBUG   = 4;
	const ALL     = 5;


	private $_out;
	private $_lf = array();
	private $_level;


	function __construct(OutputAdapter $out, $level = self::DEBUG){
		$this->_out = $out;
		$this->_level = $level;
	}


	function addFormat(LoggerFormat $lf){
		$this->_lf[] = $lf;
	}


	function setLevel($level){
		$this->_level = $level;
	}


	/* ========================== */


	function log($message, $level){
		if ($this->_level >= $level){
			// Format log
			foreach(array_reverse($this->_lf) as $lf)
				$message = $lf->format($message);

			$this->_out->write($message);
		}
	}


	/* ========================== */


	function logError($message){
		$this->log($message, Logger::ERROR);
	}


	function logWarning($message){
		$this->log($message, Logger::WARNING);
	}


	function logInfo($message){
		$this->log($message, Logger::INFO);
	}


	function logDebug($message){
		$this->log($message, Logger::DEBUG);
	}
}

