<?
namespace pfc;

interface Compressor{
	function deflate($data);
	function inflate($data);
}

