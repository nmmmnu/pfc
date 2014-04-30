<?
namespace pfc\SQL;

use pfc\SQL;
use pfc\SQLArrayResult;

use pfc\Loggable;

use pfc\Profiler;

/**
 * Decorator that uses Profiler to profile the queries
 *
 */
class ProfilerDecorator implements SQL{
	use Loggable;


	private $_sqlAdapter;
	private $_profiler;


	/**
	 * constructor
	 *
	 * @param SQL $sqlAdapter
	 * @param Profiler $profiler
	 */
	function __construct(SQL $sqlAdapter, Profiler $profiler){
		$this->_sqlAdapter = $sqlAdapter;
		$this->_profiler   = $profiler;
	}


	function getName(){
		return $this->_sqlAdapter->getName();
	}


	function open($connectionString){
		return $this->_sqlAdapter->open($connectionString);
	}


	function close(){
		return $this->_sqlAdapter->close();
	}


	function escape($string){
		return $this->_sqlAdapter->escape($string);
	}


	function query($sql, $primaryKey=NULL){
		$this->_profiler->stop("query start", $sql);
		$result = $this->_sqlAdapter->query($sql, $primaryKey);
		$m =
		$this->_profiler->stop("query end", $sql);

		$this->logDebug("Query executed for $m seconds...");

		return $result;
	}
}

