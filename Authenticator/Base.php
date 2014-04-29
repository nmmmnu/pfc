<?
namespace pfc\Authenticator;

use pfc\Authenticator;
use pfc\UnitTest;

abstract class Base implements Authenticator, UnitTest{
	private $_result;


	protected function __construct($result){
		$this->_result = $result;
	}


	function authenticate($host, $username, $password){
		return $this->_result;
	}
}

