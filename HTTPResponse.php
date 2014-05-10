<?
namespace pfc;

class HTTPResponse{
	private $_headers;
	private $_content;
	
	
	function __construct(){
		$this->_headers = array();
	}
	
	
	private static function chkHeader($string) {
		$string = strtolower($string);
		
		if (preg_match("/^[a-z0-9\-]+$/", $string))
			return implode("-", array_map('ucfirst', explode("-", $string)));
		
		return false;
	}


	function setHeader($header, $value){
		$header = self::chkHeader($header);

		if ($header == "")
			return;
			
		$this->_headers[$header] = $value;
	}
	
	
	function sendHeaders(){
		foreach($headers as $header => $value)
			header("$header: $value");
	}
	
	
	function dumpHeaders(){
		printf("HTTP/1.0 200 OK\n");

		foreach($this->_headers as $header => $value)
			printf("%s: %s\n", $header, $value);

		printf("\n");
	}


	function setContent($content){
		$this->_content = $content;
		
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


