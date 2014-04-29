<?
namespace pfc\OutputAdapter;

/**
 * Console StreamAdapter
 *
 * supports "writting" to Console (STDERR)
 *
 */
 class Console extends File{
	function __construct(){
		parent::__construct(STDERR);
	}
}

