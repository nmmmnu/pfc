<?
namespace pfc\Framework\Response;


use pfc\Framework\Response;
use pfc\HTTPResponse;


class Redirect implements Response{
	private $_location;


	function __construct($location){
		$this->_location = $location;
	}


	function process(){
		$http = new HTTPResponse();
		$http->setResponce(302);
		$http->setHeader("location", $this->_location);

		return $http;
	}


	static function test(){
		\pfc\UnitTests\ResponseTests::test(new self("/"));
	}
}

