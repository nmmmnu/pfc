<?
namespace pfc\Serializer;

use pfc\Serializer;
use pfc\UnitTest;

/**
 * NULL Serializer
 * It does not serialize the data in any way,
 * this means that if array is passed,
 * the interactions with some objects such Redis will still works,
 * but the interactions with other objects may fail
 *
 */
class NULLAdapter implements Serializer, UnitTest{
	function serialize($data){
		return $data;
	}


	function unserialize($data){
		return $data;
	}


	static function test(){
		$ser = new NULLAdapter();

		$data = "bla";

		assert( $data == $ser->serialize($data) );
		assert( $data == $ser->unserialize($data) );
	}
}

