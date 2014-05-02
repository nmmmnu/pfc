<?
namespace pfc\Compressor;

use pfc\Compressor;
use pfc\UnitTest;

/**
 * gz deflate Compressor
 *
 */
class GZDeflate implements Compressor{
	function inflate($data){
		return gzinflate($data);
	}


	function deflate($data){
		$data = @gzdeflate($data);

		if ($data === false)
			return false;

		return $data;
	}


	static function test(){
		$gz = new GZDeflate();

		$s = "testing...";

		$compressed = $gz->deflate($s);

		assert($s == $gz->inflate($compressed));
	}

}

