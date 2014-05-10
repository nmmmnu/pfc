<?
namespace pfc\UnitTests;

use pfc\Callback;
use pfc\CallbackCollection;

class CallbackCollectionTests{
	const DELIMITER = "-";


	function mysql($host, $user, $pass){
		return implode(self::DELIMITER, array($host, $user, $pass) );
	}


	function redis($host, $port){
		return implode(self::DELIMITER, array($host, $port) );
	}



	static function test(){
		$r = new CallbackCollection();

		$configMySQL = array(
			"host"	=> "localhost"	,
			"user"	=> "admin"	,
			"pass"	=> "secret"
		);

		$configRedis = array(
			"host"	=> "127.0.0.1"	,
			"port"	=> 6379
		);

		$r->map("mysql", new Callback(__CLASS__ . "::mysql",	$configMySQL));
		$r->map("redis", new Callback(__CLASS__ . "::redis",	$configRedis));

		self::testResources($r, "mysql", $configMySQL);
		self::testResources($r, "redis", $configRedis);
	}


	static function testResources(CallbackCollection $r, $name, array $params){
		$paramTest = implode(self::DELIMITER, $params);
		assert($r->exec($name) == $paramTest);
	}
}

