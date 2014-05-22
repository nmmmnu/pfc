<?
namespace pfc\Authenticator;

use pfc\Authenticator;

abstract class Base implements Authenticator{
	private $_result;


	protected function __construct($result){
		$this->_result = $result;
	}


	function authenticate($host, $username, $password){
		return $this->_result;
	}
}

