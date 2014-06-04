<?
namespace pfc\Compressor;


/**
 * gz deflate Compressor
 *
 */
class GZDeflate implements Compressor{
	function deflate($data){
		return gzdeflate($data);
	}


	function inflate($data){
		$data = @gzinflate($data);

		if ($data === false)
			return false;

		return $data;
	}


	static function test(){
		\pfc\UnitTests\CompressorTests::test( new GZDeflate() );
	}
}

