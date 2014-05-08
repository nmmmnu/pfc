<?
namespace tests;


error_reporting(E_ALL);


if (true){
	// PDO
	
	$connection = array(
	//	"connection_string" => "mysql:unix_socket=/tmp/akonadi-nmmm.LmQgHJ/mysql.socket;dbname=test",
		"connection_string" => "sqlite:" . "/dev/shm/" . "test.database.sqlite3",
		"user",
		"password"
	);

	$real_db = new \pfc\SQL\PDO($connection);
}else{
	// MySQLi
	
	$connection = array(
		"database"	=> "test",
		"socket"	=> "/tmp/akonadi-nmmm.LmQgHJ/mysql.socket"
	);

	$real_db = new \pfc\SQL\MySQLi($connection);
}


// prepare Profiller
$profiler = new \pfc\Profiler();


// prepare Logger + format
$logger = new \pfc\Logger();
$logger->addOutput(new \pfc\OutputAdapter\Console());
$logger->addFormat(new \pfc\LoggerFormat\Date() );
$logger->addFormat(new \pfc\LoggerFormat\Profiler( new \pfc\Profiler() ) );
$logger->addFormat(new \pfc\LoggerFormat\String("db_test") );


// make SQL to be profilled
$prof_db = new \pfc\SQL\ProfilerDecorator($real_db, new \pfc\Profiler() );
$prof_db->setLogger($logger);


// make SQL to throw exceptions
$db = new \pfc\SQL\ExceptionDecorator($prof_db);


// prepare Cache in /dev/shm + Gzip
$cacheAdapterFile = new \pfc\CacheAdapter\Shm("sql_cache_");
$cacheAdapterFile->setTTL(10);
$cacheAdapter     = new \pfc\CacheAdapter\CompressorDecorator($cacheAdapterFile, new \pfc\Compressor\GZip());


// set Serializer to JSON
$serializer   = new \pfc\Serializer\JSON();


// make SQL to be cached
$db2 = new \pfc\SQL\CacheDecorator($db, $cacheAdapter, $serializer);
$db2->setLogger($logger);

