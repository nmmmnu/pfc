<?
namespace pfc\Authenticator;

use pfc\Authenticator;
use pfc\UnitTest;

/**
 * allow / deny access according the user password storred in array
 */
class ArrayPassword implements Authenticator, UnitTest{
	private $_array;


	/**
	 * constructor
	 *
	 * @param array $array array with users as key, passwords as values
	 *
	 */
	protected function __construct(array $array){
		$this->_array = $array;
	}


	function authenticate($host, $username, $password){
		$x = $this->hash($password);
		return @$this->_array[$username] == $x;
	}


	/**
	 * optional password hashing
	 *
	 * could be a good idea to become a class
	 *
	 * @param string $password the value to be hashed
	 * @return boolean
	 */
	protected function hash($password){
		return $password;
	}


	static function test(){
		$a = array(
			"admin" => "pass"
		);
		$auth = new ArrayPassword($a);

		assert($auth->authenticate(null, "admin", "pass") == true);
		assert($auth->authenticate(null, "admin2", "pass") == false);
		assert($auth->authenticate(null, "admin", "pass2") == false);
		assert($auth->authenticate(null, "admin2", "pass2") == false);
	}
}

