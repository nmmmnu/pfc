<?
namespace pfc\UnitTests;


use pfc\Framework\Router;

use pfc\Framework\Route,
	pfc\Framework\Path\Exact,
	pfc\Framework\Path\Mask,
	pfc\Framework\Path\CatchAll;


class RouterTests{
	function exact($_path){
		return "[$_path] exact";
	}


	function all(){
		return "catch all";
	}


	function blog($_path, $id, $user){
		return "[$_path] Blog id: $id, User: $user";
	}


	static function test(){
		$realinj = new \injector\Injector();
		$inj     = new \injector\SingletonInjector($realinj);


		$r = new Router();

		$r->map("/",		new Route(new Exact("/"),		$inj, __CLASS__ . "::exact"	));
		$r->map("/about",	new Route(new Exact("/about.php"),	$inj, __CLASS__ . "::exact"	));
		$r->map("/contact",	new Route(new Exact("/contact.php"),	$inj, __CLASS__ . "::exact"	));

		$r->map("/blog",	new Route(new Mask("/blog/{user}/{id}"),$inj, __CLASS__ . "::blog"	));

		$r->map("/all",		new Route(new CatchAll("/"),		$inj, __CLASS__ . "::all"	));

		echo "Router testing...\n";

		self::testRoute($r, "/blog/niki/45",	"[/blog/niki/45] Blog id: 45, User: niki"	);
		self::testRoute($r, "/about.php",	"[/about.php] exact"				);
		self::testRoute($r, "/404", 		"catch all"					);
	}

	static function testRoute(Router $r, $path, $expect){
		$result = $r->processRequest($path);

		printf("%-15s => %s\n", $path, $result);
		assert($result === $expect);
	}
}

