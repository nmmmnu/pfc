<?
namespace pfc;

interface Compressor{
	function inflate($data);
	function deflate($data);
}

