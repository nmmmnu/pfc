<?
namespace pfc\LoggerFormat;


use pfc\Profiler as pfc_Profiler;


/**
 * Add profiling information
 *
 * decorate a string for logging purposes
 *
 */
class Profiler implements LoggerFormat{
	private $_profiler;


	/**
	 * constructor
	 *
	 * @param \pfc\Profiler $profiler
	 *
	 */
	function __construct(pfc_Profiler $profiler){
		$this->_profiler = $profiler;
	}


	function format($message){
		$info = sprintf("%4.4f sec, %4.4f sec total" ,
			$this->_profiler->stop(),
			$this->_profiler->getTotal()
		);

		return $info . self::SEPARATOR . $message;
	}
}


