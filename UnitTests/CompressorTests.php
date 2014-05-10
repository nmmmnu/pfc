<?
namespace pfc\UnitTests;

use pfc\Compressor;

class CompressorTests{
	static function test(Compressor $compressor){
		$data = "testing...";

		$compressed_data    = $compressor->deflate($data);
		$un_compressed_data = $compressor->inflate($compressed_data);

		/*
		var_dump($compressed_data);
		var_dump($un_compressed_data);
		var_dump($data);
		*/

		assert($data == $un_compressed_data);
	}
}
