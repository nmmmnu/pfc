<?
namespace pfc\UnitTests;

use \pfc\Serializer\Serializer;

class SerializerTests{
	static function test(Serializer $serializer){
		$data = array( "bla" => 100 );

		$sdata = $serializer->serialize($data);

		assert( $data == $serializer->unserialize($sdata) );
	}

}
