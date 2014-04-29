<?
namespace pfc\Serializer;

use pfc\Serializer;
use pfc\UnitTest;

/**
 * PHP standard Serializer
 *
 */
class PHP implements Serializer, UnitTest{
	function serialize($data){
		return serialize($data);
	}

	
	function unserialize($data){
		return @unserialize($data);
	}


	static function test(){
		$data = array( "bla" => 100 );

		$ser = new PHP();

		$sdata = $ser->serialize($data);

		assert( $data == $ser->unserialize($sdata) );
	}
}

