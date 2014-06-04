<?
namespace pfc\Compressor;

interface Compressor{
	function deflate($data);
	function inflate($data);
}

