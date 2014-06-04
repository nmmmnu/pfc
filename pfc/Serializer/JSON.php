<?
namespace pfc\Serializer;


/**
 * JSON Serializer
 *
 */
class JSON implements Serializer{
	function serialize($data){
		return json_encode($data);
	}


	function unserialize($data){
		$x = @json_decode($data, true);

		if ($x == NULL)
			return false;

		return $x;
	}


	function getContentType(){
		return "text/json";
	}


	static function test(){
		\pfc\UnitTests\SerializerTests::test( new JSON() );
	}
}

