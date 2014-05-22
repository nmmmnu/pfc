<?
namespace pfc;

/**
 * Abstract Error handler
 *
 */
abstract class ErrorHandler{
	const     hname = "vhandler";


	protected $_html;
	private $_suppress;


	function __construct($html = true, $suppress = false){
		$this->_html     = $html;
		$this->_suppress = $suppress;
	}

	function register(){
		$callback = array($this, self::hname);
		set_error_handler($callback);
	}


	function vhandler($errno, $errstr, $errfile, $errline, $errcontext){
		if (0){
			printf("%10s %016d\n", "error",  decbin($errno));
			printf("%10s %016d\n", "report", decbin(error_reporting()));
			printf("%10s %016d\n", "result", decbin($errno & error_reporting()));
		}

		if ($errno & error_reporting())
			$this->handler($errno, $errstr, $errfile, $errline, $errcontext);
		else
			$this->supressed_msg();

		if (in_array($errno, array(E_ERROR, E_USER_ERROR) ) )
			exit(1);

		return true;
	}


	abstract function handler($errno, $errstr, $errfile, $errline, $errcontext);


	abstract function supressed_msg();


	protected function getErrorType($errno){
		$level_names = array(
			E_ERROR			=> 'ERROR',
			E_WARNING		=> 'WARNING',
			E_PARSE			=> 'PARSE',
			E_NOTICE		=> 'NOTICE',
			E_CORE_ERROR		=> 'CORE_ERROR',
			E_CORE_WARNING		=> 'CORE_WARNING',
			E_COMPILE_ERROR		=> 'COMPILE_ERROR',
			E_COMPILE_WARNING	=> 'COMPILE_WARNING',
			E_USER_ERROR		=> 'USER_ERROR',
			E_USER_WARNING		=> 'USER_WARNING',
			E_USER_NOTICE		=> 'USER_NOTICE'
		);

		if(defined('E_STRICT'))
			$level_names[E_STRICT]='STRICT';

		if (isset($level_names[$errno]))
			return $level_names[$errno];

		return "OTHER_ERROR";
	}


	protected function printStackTrace(){
		$buffer = "";

		$br = $this->_html ? "<br>" : "";

		$show = false;
		$row = 0;
		foreach(debug_backtrace() as $line){
			if (@$line["function"] == self::hname){
				$show = true;
				continue;
			}

			if ($show == false)
				continue;

			$args = "";
			if (isset($line["args"]))
				foreach($line["args"] as $arg){
					if (is_array($arg))
						$arg = "array";

					if (is_object($arg))
						$arg = "object";

					if ($args == "")
						$args .= sprintf("'%s'", $arg);
					else
						$args .= sprintf(", '%s'", $arg);
				}

			$buffer .= sprintf("%4d %-20s(%d) %s(%s) $br\n",
				$row,
				@$line["file"],
				@$line["line"],
				@$line["function"],
				$args
			);

			$row++;
		}

		return $buffer;
	}
}

