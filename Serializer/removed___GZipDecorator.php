<?
namespace pfc\Serializer;

use pfc\Serializer;
use pfc\UnitTest;

/**
 * GZipDecorator Serializer
 * This decorator compress the data from the Serializer to gzip format
 * If written to file, utilities like gzip / zcat can be used
 *
 */
class GZipDecorator implements Serializer, UnitTest{

	/**
	 * constructor
	 * 
	 * @param Serializer $serializer
	 */
	function __construct(Serializer $serializer){
		$this->serializer = $serializer;
	}

	function serialize($data){
		$data = $this->serializer->serialize($data);

		if ($data === false)
			return false;

		return gzencode($data);
	}

	function unserialize($data){
		if ($data === false)
			return false;
		
		$data = @gzdecode($data);

		if ($data === false)
			return false;

		return $this->serializer->unserialize($data);
	}



	static function test(){
		$ser = new GZipDecorator(new JSON());

		$data = "bla";

		assert( $data == $ser->unserialize($ser->serialize($data)) );
	}
}

