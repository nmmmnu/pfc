<?
namespace pfc\Framework;


interface Route{
	const HOMEPATH = "/";

	function match($path);
	function link(array $params);
}

