<?
namespace pfc\Compressor;

use pfc\Compressor;

/**
 * zlib Compressor
 *
 */
class ZLib implements Compressor{
	function deflate($data){
		return gzcompress($data);
	}


	function inflate($data){
		$data = @gzuncompress($data);

		if ($data === false)
			return false;

		return $data;
	}


	static function test(){
		\pfc\UnitTests\CompressorTests::test( new ZLib() );
	}
}

