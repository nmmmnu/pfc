<?
namespace pfc\DependencyInjection;


use \ArrayAccess;


class Dependency implements ArrayAccess{
	private $_data       = array();
	private $_loader     = null;

	private $_parentsObj = array();
	private $_parentsArr = array();


	function __construct(Loader $loader = null) {
		$this->_loader = $loader;
	}


	function addParent($dependency){
		if (is_array($dependency)){
			$this->_parentsArr[] = $dependency;
			return;
		}

		if (is_object($dependency)){
			if ($dependency instanceof ArrayAccess)
				$this->_parentsObj[] = $dependency;

			return;
		}
	}


	function clear(){
		$this->_data = array();
	}


	private function getFromParent($offset){
		foreach($this->_parentsObj as $dep){
			$value = $dep[$offset];
			if ($value)
				return $value;
		}

		foreach($this->_parentsArr as $dep){
			if (isset($dep[$offset]))
				return $dep[$offset];
		}

		return null;
	}


	/* Magic functions */

	function offsetSet($offset, $value) {
		if (is_null($offset))
			return;

		$this->_data[$offset] = $value;
	}


	function offsetExists($offset) {
		if ( isset($this->_data[$offset]) )
			return true;

		return null;
	}


	function offsetUnset($offset) {
		unset($this->_data[$offset]);
	}


	function offsetGet($offset) {
		if (isset($this->_data[$offset]))
			return $this->_data[$offset];

		// Try the loader
		if ($this->_loader){
			$value = $this->_loader->load($offset);

			if ($value){
				$this->_data[$offset] = $value;
				return $value;
			}
		}

		// Try the parents
		return $this->getFromParent($offset);
	}


	/* tests */

	static function test(){
		$parent1 = new self();
		$parent1["parent1"] = "test_parent1";

		$parent2 = array(
			"parent2"	=> "test_parent2"
		);


		$loader = new Loader\ArrayLoader(array(
			"loader_1"	=> "test"	,
			"loader_2"	=> array("test", "bla")
		));


		$registry = new self($loader);
		$registry->addParent($parent1);
		$registry->addParent($parent2);


		$registry["xxx"] = "testxxx";


		assert($registry["xxx"] == "testxxx");
		// loader
		assert($registry["loader_1"] == "test");
		assert($registry["loader_2"][0] == "test");
		// parent
		assert($registry["parent1"] == "test_parent1");
		assert($registry["parent2"] == "test_parent2");
	}
}


