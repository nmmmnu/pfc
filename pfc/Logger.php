<?
namespace pfc;

class Logger{
	const OFF     = 0;
	const ERROR   = 1;
	const WARNING = 2;
	const INFO    = 3;
	const DEBUG   = 4;
	const ALL     = 5;


	private $_out = array();
	private $_lf = array();
	private $_level;


	function __construct($level = self::DEBUG){
		$this->_level = $level;
	}


	function addOutput(OutputAdapter $out){
		$this->_out[] = $out;
	}


	function addFormat(LoggerFormat $lf){
		$this->_lf[] = $lf;
	}


	function setLevel($level){
		$this->_level = $level;
	}


	/* ========================== */


	private function formatMessage($message){
		foreach(array_reverse($this->_lf) as $lf)
			$message = $lf->format($message);

		return $message;
	}


	/* ========================== */


	function log($message, $level){
		if ($this->_level >= $level){
			$message = $this->formatMessage($message);

			foreach($this->_out as $out)
				$out->write($message);
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

