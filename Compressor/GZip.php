<?
namespace pfc\Compressor;

use pfc\Compressor;

/**
 * GZip Compressor
 *
 * If written to file, utilities like gzip / zcat can be used
 *
 */
class GZip implements Compressor{
	function deflate($data){
		return gzencode($data);
	}


	function inflate($data){
		$data = @gzdecode($data);

		if ($data === false)
			return false;

		return $data;
	}


	static function test(){
		\pfc\UnitTests\CompressorTests::test( new GZip() );
	}

}

