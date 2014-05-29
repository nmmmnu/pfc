<?
namespace demo_app\models;

class ppl{
	private $db;


	function __construct(\pfc\SQL $db){
		$this->db = $db;
	}


	function getAll(){
		return $this->db->query("select * from ppl", array() );
	}


	function get($id){
		return $this->db->query("select * from ppl where id = %s", array($id) );
	}
}

