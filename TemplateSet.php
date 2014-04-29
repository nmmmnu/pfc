<?
namespace pfc;

/**
 * Set using template method returning AbstractList
 *
 */
abstract class TemplateSet extends Set{

	function __construct(){
		parent::__construct( $this->getList() );
	}


	/**
	 * Template method
	 *
	 * @param string $dbname name of the database to connect to
	 * @return AbstractList for use in the constructor
	 */
	abstract protected function getList();
}

