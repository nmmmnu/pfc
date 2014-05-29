<?
namespace pfc;


class HTTPResponse{
	private $_responce;
	private $_headers = array();
	private $_content;


	const DEFAULT_PROTOCO		= "HTTP/1.0";
	const DEFAULT_CONTENT_TYPE	= "text/html";


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


	function __construct($content = "", $content_type = self::DEFAULT_CONTENT_TYPE){
		$this->setResponce(200);

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


	private static function getProtocol(){
		if (isset($_SERVER["SERVER_PROTOCOL"]))
			return $_SERVER["SERVER_PROTOCOL"];

		return self::DEFAULT_PROTOCOL;
	}


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


	function setHeader($header, $value){
		$header = self::chkHeader($header);

		if ($header === false)
			return;

		$this->_headers[$header] = $value;
	}


	function sendHeaders(){
		// if apache_get_modules() exists, then PHP running as SAPI,
		// so we can pass "HTTP/1.0 200 OK" header
		// however it works on CGI from some time.
		// if (function_exists("apache_get_modules"))

		header($this->_responce);

		foreach($this->_headers as $header => $value)
			header("$header: $value");
	}


	function dumpHeaders(){
		printf($this->_responce . "\n");

		foreach($this->_headers as $header => $value)
			printf("%s: %s\n", $header, $value);

		printf("\n");
	}


	function setContent($content, $content_type = self::DEFAULT_CONTENT_TYPE){
		$this->_content = $content;

		$this->setHeader("Content-Type", $content_type);
		$this->setHeader("Content-Length", strlen($content));
	}


	function sendContent(){
		echo $this->_content;
	}


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


