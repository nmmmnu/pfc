<?
namespace pfc;


/**
 * HTTPResponse
 *
 * produse HTTP response similar to:
 *
 * [begin]
 * HTTP/1.0 200 OK
 * Content-Type: text/html
 *
 * <p>Hello World</p>
 * [end]
 */
class HTTPResponse{
	private $_responce;
	private $_headers = array();
	private $_content;


	const DEFAULT_PROTOCOL		= "HTTP/1.0";
	const DEFAULT_CODE		= 200;
	const DEFAULT_ERROR_CODE	= 500;
	const DEFAULT_CONTENT_TYPE	= "text/html";


	/**
	 * result codes mapped to text, e.g. "200 OK"
	 */
	public static $HTTP_CODES = array(
			200	=>	"OK"			,

			301	=>	"Moved"			,
			302	=>	"Found"			,

			400	=>	"Bad request"		,
			401	=>	"Unauthorized"		,
			403	=>	"Forbidden"		,
			404	=>	"Not Found"		,

			500	=>	"Internal Error"	,
			501	=>	"Not implemented"	,
			503	=>	"Gateway timeout"	,
	);


	/**
	 * constructor
	 *
	 * @param string $content content
	 * @param string $content_type content-type header (text/html)
	 * @param int $code http code (HTTP/1.0 200 OK)
	 */
	function __construct($content = "", $content_type = self::DEFAULT_CONTENT_TYPE, $code = 0){
		if ($code <= 0)
			$code = self::DEFAULT_CODE;

		$this->setResponce($code);

		$this->setHeader("Date", gmdate(DATE_RFC850));
		$this->setHeader("X-Powered-By", Info::PRODUCT . " " . Info::VERSION());

		$this->setContent($content, $content_type);
	}


	private static function chkHeader($string) {
		$string = strtolower($string);

		if (preg_match("/^[a-z0-9\-]+$/", $string))
			return implode("-", array_map('ucfirst', explode("-", $string)));

		return false;
	}


	/**
	 * get HTTP protocol version
	 *
	 * HTTP/1.0
	 *
	 */
	static function getProtocol(){
		if (isset($_SERVER["SERVER_PROTOCOL"]))
			return $_SERVER["SERVER_PROTOCOL"];

		return self::DEFAULT_PROTOCOL;
	}


	/**
	 * set HTTP response
	 *
	 * HTTP/1.0 200 OK
	 *
	 * @param string $code number part (e.g. 200)
	 * @param string|boolean $text text part (e.g. "OK")
	 *
	 */
	function setResponce($code = 200, $text = false){
		if ($code <= 0)
			$code = 200;

		if ($text === false){
			if (!isset(self::$HTTP_CODES[$code]))
				$code = 200;

			$text = self::$HTTP_CODES[$code];
		}

		$this->_responce = self::getProtocol() . " $code $text";
	}


	/**
	 * set HTTP header
	 *
	 * location: /index.php
	 *
	 * @param string $header name (e.g. "location")
	 * @param string $value value (e.g. "/index.php")
	 *
	 */
	function setHeader($header, $value){
		$header = self::chkHeader($header);

		if ($header === false)
			return;

		$this->_headers[$header] = $value;
	}


	/**
	 * send HTTP headers to the client
	 *
	 */
	function sendHeaders(){
		// if apache_get_modules() exists, then PHP running as SAPI,
		// so we can pass "HTTP/1.0 200 OK" header
		// however it works on CGI from some time.
		// if (function_exists("apache_get_modules"))

		header($this->_responce);

		foreach($this->_headers as $header => $value)
			header("$header: $value");
	}


	/**
	 * dump HTTP headers
	 *
	 * for testing purposes
	 *
	 */
	function dumpHeaders(){
		printf($this->_responce . "\n");

		foreach($this->_headers as $header => $value)
			printf("%s: %s\n", $header, $value);

		printf("\n");
	}


	/**
	 * set content
	 *
	 * @param string $content content
	 * @param string $content_type content-type header
	 *
	 */
	function setContent($content, $content_type = self::DEFAULT_CONTENT_TYPE){
		$this->_content = $content;

		$this->setHeader("Content-Type", $content_type);
		$this->setHeader("Content-Length", strlen($content));
	}


	/**
	 * send content to the client
	 *
	 */
	function sendContent(){
		echo $this->_content;
	}


	/**
	 * send response to the client
	 *
	 * send headers, then send content
	 *
	 * @param boolean $dump whatever to dump headers for testing
	 *
	 */
	function send($dump = false){
		if ($dump)
			$this->dumpHeaders();
		else
			$this->sendHeaders();

		$this->sendContent();
	}


	static function test(){
		$responce = new HTTPResponse();
		$responce->setHeader("some-header-name", "some-value");
		$responce->setContent("<p>hello</p>\n");
		$responce->send($dump = true);
	}
}


