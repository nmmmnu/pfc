<?
namespace tests;


$connection = array(
	"connection_string" => "mysql:unix_socket=/tmp/akonadi-nmmm.4ApOk1/mysql.socket;dbname=test",
//	"connection_string" => "sqlite:" . __DIR__ . "/../data/test.database.sqlite3",
	"user",
	"password"
);

$real_db = new \pfc\SQL\PDO($connection);



/*
$connection = array(
	"database"	=> "test",
	"socket"	=> "/tmp/akonadi-nmmm.4ApOk1/mysql.socket"
);

$real_db = new \pfc\SQL\MySQLi($connection);
*/


$profiler = new \pfc\Profiler();

$logger = new \pfc\Logger( new \pfc\OutputAdapter\Console() );
$logger->addFormat(new \pfc\LoggerFormat\Date() );
$logger->addFormat(new \pfc\LoggerFormat\Profiler( new \pfc\Profiler() ) );
$logger->addFormat(new \pfc\LoggerFormat\String("db_test") );


$prof_db = new \pfc\SQL\ProfilerDecorator($real_db, new \pfc\Profiler() );
$prof_db->setLogger($logger);

$db = new \pfc\SQL\ExceptionDecorator($prof_db);

$cacheAdapterFile = new \pfc\CacheAdapter\Shm("sql_cache_");
$cacheAdapter     = new \pfc\CacheAdapter\GZipDecorator($cacheAdapterFile);

$serializer   = new \pfc\Serializer\JSON();

$db2 = new \pfc\SQL\CacheDecorator($db, $cacheAdapter, $serializer, 20 );
$db2->setLogger($logger);

