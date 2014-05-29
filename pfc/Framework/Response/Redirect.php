<?
namespace pfc\Framework\Response;


use pfc\Framework\Response;


class Redirect implements Response{
	private $_location;


	function __construct($location){
		$this->_location = $location;
	}


	function process(){
		$http = new \pfc\HTTPResponse();
		$http->setResponce(302);
		$http->setHeader("location", $this->_location);

		return $http;
	}
}

