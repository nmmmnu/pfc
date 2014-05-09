<?
namespace pfc;

/**
 * Abstract Error handler
 *
 */
abstract class ErrorHandler{
	use Loggable;

	static function register(ErrorHandler $instance){
		$callback = array($instance, "handler");
		set_error_handler($callback);
	}

	static function getErrorType($errno){
		switch ($errno) {
		case E_USER_ERROR:
			return "ERROR";

		case E_USER_WARNING:
			return "WARNING";

		case E_USER_NOTICE:
			return "NOTICE";

		}

		return "OTHER_ERROR";
	}

	abstract function handler($errno, $errstr, $errfile, $errline, $errcontext);
}

