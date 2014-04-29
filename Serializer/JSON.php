<?
namespace pfc\Serializer;

use pfc\Serializer;
use pfc\UnitTest;

/**
 * JSON Serializer
 *
 */
class JSON implements Serializer, UnitTest{
	function serialize($data){
		return json_encode($data);
	}

	
	function unserialize($data){
		$x = @json_decode($data, true);

		if ($x == NULL)
			return false;

		return $x;
	}


	static function test(){
		$data = array( "bla" => 100 );

		$ser = new JSON();

		$sdata = $ser->serialize($data);

		assert( $data == $ser->unserialize($sdata) );
	}
}

