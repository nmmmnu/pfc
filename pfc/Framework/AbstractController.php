<?
namespace pfc\Framework;

interface AbstractController{
	function setRouting($path, array $args);
	function process();
}
