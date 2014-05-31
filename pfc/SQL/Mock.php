<?
namespace pfc\SQL;

use pfc\SQL,
	pfc\SQLResult;


/**
 * Mock class
 *
 * query always returns the array passed by constructor
 *
 */
class Mock implements SQL{
	use TraitEscape;


	private $_data;


	/**
	 * constructor
	 *
	 * @param array $data array to be used as result
	 */
	function __construct(array $data = array() ){
		$this->_data = array_values($data);
	}


	function getName(){
		return "test";
	}


	function getParamsHelp(){
		return array();
	}


	function open(){
		// Connected
	}


	function close(){
		// Disconnected
	}


	function escape($string){
		return $string;
	}


	function query($sql, array $params, $primaryKey = false){
		return new SQLResult(
			new ArrayResult($this->_data),
			$primaryKey);
	}


	static function test(){
		$db = new Mock(
			array(
				array("id" => 1, "city" => "London"	),
				array("id" => 2, "city" => "Bonn"	),
				array("id" => 3, "city" => "Boston"	),
			)
		);

		$db->open("Bla");

		// ====================

		$result = $db->query("select * from bla", array(), "city");

		assert($result->affectedRows() == 3);

		$res = \pfc\Iterators::toArray($result);

		//echo "You should see SQL result as array:\n";
		print_r($res);

		assert($res["Bonn"]["id"  ] == 2      );
		assert($res["Bonn"]["city"] == "Bonn" );

		// ====================

		$result = $db->query("select * from bla", array() );

		assert($result->affectedRows() == 3);

		$res = \pfc\Iterators::toArray($result);

		//echo "You should see SQL result as array:\n";
		print_r($res);

		assert($res[1]["id"  ] == 2      );
		assert($res[1]["city"] == "Bonn" );
	}
}

