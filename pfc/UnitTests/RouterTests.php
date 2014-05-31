<?
namespace pfc\UnitTests;

use pfc\Framework\AbstractController,
	pfc\Framework\Controller;

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

		$r->bind("/",		new Route(new Exact("/"),		new Controller($inj, __CLASS__ . "::exact")	));
		$r->bind("/about",	new Route(new Exact("/about.php"),	new Controller($inj, __CLASS__ . "::exact")	));
		$r->bind("/contact",	new Route(new Exact("/contact.php"),	new Controller($inj, __CLASS__ . "::exact")	));

		$r->bind("/blog",	new Route(new Mask("/blog/{user}/{id}"),new Controller($inj, __CLASS__ . "::blog")	));

		$r->bind("/all",	new Route(new CatchAll("/"),		new Controller($inj, __CLASS__ . "::all")	));

		echo "Router testing...\n";

		self::testRoute($r, "/blog/niki/45",	"[/blog/niki/45] Blog id: 45, User: niki"	);
		self::testRoute($r, "/about.php",	"[/about.php] exact"				);
		self::testRoute($r, "/404", 		"catch all"					);
	}

	static function testRoute(Router $r, $path, $expect){
		$controller = $r->processRequest($path);
		$result = $controller->process();


		printf("%-15s => %s\n", $path, $result);
		assert($result === $expect);
	}
}
