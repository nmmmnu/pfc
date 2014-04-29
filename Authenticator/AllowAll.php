<?
namespace pfc\Authenticator;

/**
 * always allow access
 */
class AllowAll extends Base{
	function __construct(){
		parent::__construct(true);
	}


	static function test(){
		$auth = new AllowAll();
		assert($auth->authenticate(null, null, null) == true);
	}
}

