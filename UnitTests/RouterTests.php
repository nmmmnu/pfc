<?
namespace pfc\UnitTests;

use pfc\Framework\Router;

use pfc\Framework\Route,
	pfc\Framework\Path\Exact,
	pfc\Framework\Path\Mask,
	pfc\Framework\Path\CatchAll;

use pfc\Callback;
use pfc\ArrayList;

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
		$store = new ArrayList();

		$params = array(
			"_data" => "test"
		);

		$r = new Router();

		$r->map("/",		new Route(new Exact("/"),		new Callback(__CLASS__ . "::exact",	$params,	$store)	));
		$r->map("/about",	new Route(new Exact("/about.php"),	new Callback(__CLASS__ . "::exact",	$params,	$store)	));
		$r->map("/contact",	new Route(new Exact("/contact.php"),	new Callback(__CLASS__ . "::exact",	$params,	$store)	));

		$r->map("/blog",	new Route(new Mask("/blog/{user}/{id}"),new Callback(__CLASS__ . "::blog",	$params,	$store)	));

		$r->map("/all",		new Route(new CatchAll("/"),		new Callback(__CLASS__ . "::all",	$params,	$store)	));

		echo "Router testing...\n";

		self::testRoute($r, "/blog/niki/45",	"[/blog/niki/45] Blog id: 45, User: niki"	);
		self::testRoute($r, "/about.php",	"[/about.php] exact"				);
		self::testRoute($r, "/404", 		"catch all"					);

		// check if there is only one object into the object storage
		assert(count($store) == 1);
	}

	static function testRoute(Router $r, $path, $expect){
		$result = $r->processRequest($path);

		printf("%-15s => %s\n", $path, $result);
		assert($result === $expect);
	}
}

