<?
namespace pfc\Framework\Path;

interface Path{
	const HOMEPATH = "/";

	function match($path);
	function link(array $params);
}

