<?
namespace pfc\Framework;

use pfc\Callback;

class RouterTests{
	function exact(){
		return "exact";
	}


	function all(){
		return "catch all";
	}


	function blog($id, $user){
		return "Blog id: $id, User: $user";
	}



	static function test(){
		$r = new Router();

		$r->map("/",		new Route\Exact("/"		),	new Callback(__CLASS__ . "::exact")	);
		$r->map("/about",	new Route\Exact("/about.php"	),	new Callback(__CLASS__ . "::exact")	);
		$r->map("/contact",	new Route\Exact("/contact.php"	),	new Callback(__CLASS__ . "::exact")	);

		$r->map("/blog",	new Route\Mask("/blog/{user}/{id}"),	new Callback(__CLASS__ . "::blog")	);

		$r->map("/all",		new Route\CatchAll("/"		),	new Callback(__CLASS__ . "::all")	);

		echo "Router testing...\n";

		self::testRoute($r, "/blog/niki/45",	"Blog id: 45, User: niki"	);
		self::testRoute($r, "/about.php",	"exact"				);
		self::testRoute($r, "/404", 		"catch all"			);
	}

	static function testRoute(Router $r, $path, $expect){
		$result = $r->processRequest($path);
		printf("%-15s => %s\n", $path, $result);
		assert($result === $expect);
	}
}

