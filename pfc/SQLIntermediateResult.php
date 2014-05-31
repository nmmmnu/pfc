<?
namespace pfc;

/**
 * SQLResult Iterator
 *
 */
interface SQLIntermediateResult{
	function affectedRows();
	function insertID();
	function fetch();
}


