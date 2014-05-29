<?
namespace pfc\Framework\Response;


use pfc\Serializer\JSON as pfc_Serializer_JSON;


class JSON extends Serializer{
	function __construct(array $data){
		parent::__construct(new pfc_Serializer_JSON(), $data);
	}


	static function test(){
		\pfc\UnitTests\ResponseTests::test(new self(array()));
	}
}

