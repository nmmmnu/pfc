<?
namespace pfc\Compressor;

use pfc\Compressor;
use pfc\UnitTest;

/**
 * zlib Compressor
 *
 */
class ZLib implements Compressor{
	function inflate($data){
		return gzuncompress($data);
	}


	function deflate($data){
		$data = @gzcompress($data);

		if ($data === false)
			return false;

		return $data;
	}


	static function test(){
		$gz = new GZip();

		$s = "testing...";

		$compressed = $gz->deflate($s);

		assert($s == $gz->inflate($compressed));
	}
}

