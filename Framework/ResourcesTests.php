<?
namespace pfc\Framework;

require_once __DIR__ . "/../__autoload.php";

class ResourcesTests{
	const DELIMITER = "-";


	function mysql($host, $user, $pass){
		return implode(self::DELIMITER, array($host, $user, $pass) );
	}


	function redis($host, $port){
		return implode(self::DELIMITER, array($host, $port) );
	}



	static function test(){
		$r = new Resources("pfc\\Framework\\");

		$configMySQL = array(
			"host"	=> "localhost"	,
			"user"	=> "admin"	,
			"pass"	=> "secret"
		);

		$configRedis = array(
			"host"	=> "127.0.0.1"	,
			"port"	=> 6379
		);

		$r->map("mysql",	"ResourcesTests::mysql",	$configMySQL);
		$r->map("redis",	"ResourcesTests::redis",	$configRedis);

		self::testResources($r, "mysql", $configMySQL);
		self::testResources($r, "redis", $configRedis);
	}


	static function testResources(Resources $r, $name, array $params){
		$paramTest = implode(self::DELIMITER, $params);
		assert($r->get($name) == $paramTest);
	}
}

