<?
namespace pfc\Framework;

require_once __DIR__ . "/../__autoload.php";

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
		$r = new Router("pfc\\Framework\\");

		$r->map("/",		new Route\Exact("/"		,	"RouterTests::exact"	));
		$r->map("/about",	new Route\Exact("/about.php"	, 	"RouterTests::exact"	));
		$r->map("/contact",	new Route\Exact("/contact.php"	, 	"RouterTests::exact"	));

		$r->map("/blog",	new Route\Mask("/blog/{user}/{id}",	"RouterTests::blog"	));

		$r->map("/all",		new Route\CatchAll("/"		, 	"RouterTests::all"	));

		echo "Router testing...\n";

		self::testRoute($r, "/blog/niki/45",	"Blog id: 45, User: niki"	);
		self::testRoute($r, "/about.php",	"exact"				);
		self::testRoute($r, "/404", 		"catch all"			);
	}

	static function testRoute(Router $r, $path, $expect){
		$r->processRequest($path);
		printf("%-15s => %s\n", $path, $r->getLastResult());
		assert($r->getLastResult() === $expect);
	}
}

