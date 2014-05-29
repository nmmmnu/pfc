<?
namespace pfc\Framework\Response;


use pfc\Framework\Response;
use pfc\Serializer as pfc_Serializer;
use pfc\HTTPResponse;


class Serializer implements Response{
	private $_serializer;
	private $_data;


	function __construct(pfc_Serializer $serializer, array $data){
		$this->_serializer	= $serializer;
		$this->_data		= $data;
	}


	function process(){
		$content	= $this->_serializer->serialize($this->_data);
		$type		= $this->_serializer->getContentType();

		return new HTTPResponse($content, $type);
	}


	static function test(){
		$json = new \pfc\Serializer\JSON();
		\pfc\UnitTests\ResponseTests::test(new self($json, array()));
	}
}

