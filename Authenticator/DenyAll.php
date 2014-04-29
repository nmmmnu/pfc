<?
namespace pfc\Authenticator;

/**
 * always deny access
 */
class DenyAll extends Base{
	function __construct(){
		parent::__construct(false);
	}


	static function test(){
		$auth = new DenyAll();
		assert($auth->authenticate(null, null, null) == false);
	}
}

