#!/usr/local/bin/php
<?
namespace pfc;
require_once __DIR__ . "/../__autoload.php";

class Test{
	function bla($mysql, $redis, $http_port){
		printf("%s\n", __METHOD__);

		var_dump($mysql);
		var_dump($redis);
		var_dump($http_port);
	}
}



$reg1 = new DependencyProvider(new Loader\ArrayLoader(array(
	"http_port" => 80
)));

$reg2 = new DependencyProvider(new Loader\INIFile(__DIR__ . "/../data/ini/"));

$arraylist1 = array($reg1);
$arraylist2 = array($reg2);

$factory = new ClassFactory();

$c = new Callback("pfc\\Test::bla", $factory, $arraylist1);
$c->exec($arraylist2);
