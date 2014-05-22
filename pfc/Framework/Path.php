<?
namespace pfc\Framework;

interface Path{
	const HOMEPATH = "/";

	function match($path);
	function link(array $params);
}

