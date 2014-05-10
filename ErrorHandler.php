<?
namespace pfc;

/**
 * Abstract Error handler
 *
 */
abstract class ErrorHandler{
	protected $_html;

	function __construct($html = true){
		$this->_html = $html;
	}

	function register(){
		$callback = array($this, "handler");
		set_error_handler($callback);
	}


	abstract function handler($errno, $errstr, $errfile, $errline, $errcontext);


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


	protected function printStackTrace($hidden_rows = 3){
		$buffer = "";

		$br = $this->_html ? "<br>" : "";

		$row = 0;
		foreach(debug_backtrace() as $line){
			$row++;
			if ($row < $hidden_rows)
				continue;

			$args = "";
			foreach($line["args"] as $arg){
				if ($args == "")
					$args .= sprintf("'%s'", $arg);
				else
					$args .= sprintf(", '%s'", $arg);
			}

			$buffer .= sprintf("%4d %-20s(%d) %s(%s) $br\n",
				$row - $hidden_rows,
				$line["file"],
				$line["line"],
				$line["function"],
				$args
			);
		}

		return $buffer;
	}
}

