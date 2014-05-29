<?
namespace pfc\Framework;

/**
 * Controller interface
 *
 */
interface AbstractController{
	/**
	 * set parameters from the router
	 *
	 * @param string $path matched path, for example /index.php
	 * @param array $args mathced arguments
	 */
	function setRouting($path, array $args);


	/**
	 * process the controller
	 *
	 * Result can be:
	 *  - string - in this case, result is interpreted as HTTP 200 OK, text/html
	 *  - Response interface
	 *  - HTTPResponse class
	 *
	 * @return string|Response|HTTPResponse
	 */
	function process();
}
