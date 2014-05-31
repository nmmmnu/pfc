<?
namespace demo_app;

error_reporting(E_ALL);


require_once __DIR__ . "/../__autoload.php";
require_once __DIR__ . "/../../php_inject/__autoload.php";


spl_autoload_register(function($class){
	$parts = explode("\\", $class);

	if ($parts[0] != __NAMESPACE__)
		return;

	unset($parts[0]);

	$file = implode("/", $parts) . ".php";

	$file = dirname(__FILE__) . "/" . $file;

	include_once $file;
});


MyApplication::start();


