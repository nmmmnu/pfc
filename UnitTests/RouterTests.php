<?
namespace pfc\UnitTests;

use pfc\Framework\Router;

use pfc\Framework\Route,
	pfc\Framework\Path\Exact,
	pfc\Framework\Path\Mask,
	pfc\Framework\Path\CatchAll;

use pfc\Callback;
use pfc\CallbackFactory;

class RouterTests{
	function exact($_path){
		return "[$_path] exact";
	}


	function all(){
		return "catch all";
	}


	function blog($_path, $id, $user, $_data){
		return "[$_path][$_data] Blog id: $id, User: $user";
	}


	static function test(){
		$params = array(
			"_data" => "test"
		);

		$cf = new CallbackFactory($params);

		$r = new Router();

		$r->map("/",		new Route(new Exact("/"),		$cf->getCallback(__CLASS__ . "::exact")	));
		$r->map("/about",	new Route(new Exact("/about.php"),	$cf->getCallback(__CLASS__ . "::exact")	));
		$r->map("/contact",	new Route(new Exact("/contact.php"),	$cf->getCallback(__CLASS__ . "::exact")	));

		$r->map("/blog",	new Route(new Mask("/blog/{user}/{id}"),$cf->getCallback(__CLASS__ . "::blog")	));

		$r->map("/all",		new Route(new CatchAll("/"),		$cf->getCallback(__CLASS__ . "::all")	));

		echo "Router testing...\n";

		self::testRoute($r, "/blog/niki/45",	"[/blog/niki/45][test] Blog id: 45, User: niki"	);
		self::testRoute($r, "/about.php",	"[/about.php] exact"				);
		self::testRoute($r, "/404", 		"catch all"					);

		// check if there is only one object into the object storage
		assert(count($cf) == 1);
	}

	static function testRoute(Router $r, $path, $expect){
		$result = $r->processRequest($path);

		printf("%-15s => %s\n", $path, $result);
		assert($result === $expect);
	}
}

