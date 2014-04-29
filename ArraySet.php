<?
namespace pfc;

/**
 * Set using ArrayList
 *
 */
class ArraySet extends TemplateSet{

	function __construct(){
		parent::__construct();
	}


	protected function getList(){
		return new ArrayList();
	}
}

