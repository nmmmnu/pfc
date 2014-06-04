<?
namespace pfc\Template;

/**
 * Abstract template engine
 *
 * probably will help in the future to implement
 * Smarty and other template engines.
 *
 */
interface Template{
	/**
	 * bind param to the template
	 *
	 * @param string $key
	 * @param string $value
	 */
	function bindParam($key, $value);


	/**
	 * bind params to the template
	 *
	 * @param array $array bind (add) params to the template
	 *
	 */
	function bindParams(array $array);


	/**
	 * Escape string, using htmlentities()
	 *
	 * @param string $string
	 * @return string
	 */
	function escape($string);


	/**
	 * render template
	 *
	 * intended to be called in user code
	 *
	 * @param string $file template file
	 * @param string $content optional content from child template to be included
	 * @return string output code, most probably HTML
	 */
	function render($file, $content = "");
}

