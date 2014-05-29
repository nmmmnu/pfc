<?
namespace pfc\Serializer;

use pfc\Serializer;

/**
 * PHP standard Serializer
 *
 */
class PHP implements Serializer{
	function serialize($data){
		return serialize($data);
	}


	function unserialize($data){
		return @unserialize($data);
	}


	function getContentType(){
		return "text/plain";
	}


	static function test(){
		\pfc\UnitTests\SerializerTests::test( new PHP() );
	}
}

