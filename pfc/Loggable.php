<?
namespace pfc;

trait Loggable{
	private $_logger      = NULL;


	function setLogger(Logger $logger){
		$this->_logger = $logger;
	}


	/* ========================== */


	function logError($message){
		if ($this->_logger)
			$this->_logger->logError($message);
	}


	function logWarning($message){
		if ($this->_logger)
			$this->_logger->logWarning($message);
	}


	function logInfo($message){
		if ($this->_logger)
			$this->_logger->logInfo($message);
	}


	function logDebug($message){
		if ($this->_logger)
			$this->_logger->logDebug($message);
	}
}
