<?
namespace pfc;

/**
 * Profiler
 *
 * This class can be used to perform micro-time measurements.
 * Similar to stopwatch.
 *
 */
class Profiler{
	private $_measurements;
	private $_baggage;
	private $_serial;


	function __construct(){
		$this->reset();
	}


	/**
	 * reset the timer and delete all stored measurements
	 *
	 */
	function reset(){
		$this->_measurements = array( $this::microtime() );
		$this->_baggage = array();
		$this->_serial = 0;

		//$this->stop();
	}


	/**
	 * stop the watch and store the measurement information
	 *
	 * @param string $key optional key about the measurement
	 * @param string $baggage optional long description about the measurement
	 */
	function stop($key = "", $baggage = false){
		$now  = $this::microtime();
		$duration = $now - end($this->_measurements);

		$key = sprintf("%04d %-20s", $this->_serial, $key);

		$this->_measurements[$key] = $now;
		if ($baggage)
			$this->_baggage[$key] = $baggage;

		$this->_serial++;

		return $this->formatDuration($duration);
	}


	/**
	 * get all measurement information
	 *
	 * @return array
	 */
	function getData(){
		$a = array();

		$start = 0;
		foreach($this->_measurements as $key => $val){
			if ($start)
				$a[$key] = $this->formatDuration($val - $start);

			$start = $val;
		}

		return $a;
	}


	/**
	 * get total time measured from reset()
	 *
	 * @return int
	 */
	function getTotal(){
		$duration = end($this->_measurements) - $this->_measurements[0];
		return $this->formatDuration($duration);
	}


	/**
	 * get all measurement information
	 *
	 * @param string $key measurement key
	 * @return string
	 */
	function getBaggage($key){
		return @$this->_baggage[$key];
	}


	private static function microtime(){
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}


	/**
	 * format measurement in order to avoid float E
	 *
	 * @param float duration the measurement
	 * @return float|string fload or string that contain a float
	 */
	protected function formatDuration($duration){
		return sprintf("%.4f", $duration);
	}


	/**
	 * tests
	 *
	 */
	static function test(){
		$p = new Profiler();

		echo "Delay: 1 seconds... ";
		sleep(1);
		echo "done.\n";

		$d1 = $p->stop("after the delay");
		$d2 = $p->stop("end");

		assert($d1 >= 1);
		assert($d2 <  1);

		assert($p->getTotal() >= 1);

		print_r($p->getData());
	}
}

