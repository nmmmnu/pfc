<?
namespace pfc;

/**
 * LoggerFormat
 *
 * decorate a string for logging purposes
 *
 */
interface LoggerFormat{
	const SEPARATOR = " | ";

	/**
	 * decorate a string
	 *
	 * @param string $message
	 * @return string
	 *
	 */
	function format($message);
}

