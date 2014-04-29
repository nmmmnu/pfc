<?
namespace pfc;

/**
 * Authenticator
 *
 */
interface Authenticator{
	/**
	 * proceed with autentication
	 *
	 * @param string $host remote hostname/ip address
	 * @param string $username username
	 * @param string $password password
	 * @return boolean
	 */
	function authenticate($host, $username, $password);
}

