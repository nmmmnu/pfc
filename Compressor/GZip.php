<?
namespace pfc\Compressor;

use pfc\Compressor;
use pfc\UnitTest;

/**
 * GZip Compressor
 *
 * If written to file, utilities like gzip / zcat can be used
 *
 */
class GZip implements Compressor{
	function inflate($data){
		$data = @gzdecode($data);

		if ($data === false)
			return false;

		return $data;
	}


	function deflate($data){
		return gzencode($data);
	}


	static function test(){
		$gz = new GZip();

		$s = "testing...";

		$compressed = $gz->deflate($s);

		assert($s == $gz->inflate($compressed));
	}
}

