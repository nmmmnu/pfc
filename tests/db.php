<?
namespace tests;

$real_db = new \pfc\SQL\PDO();

$profiler = new \pfc\Profiler();

$logger = new \pfc\Logger( new \pfc\OutputAdapter\Console() );
$logger->addFormat(new \pfc\LoggerFormat\Date() );
$logger->addFormat(new \pfc\LoggerFormat\Profiler( new \pfc\Profiler() ) );
$logger->addFormat(new \pfc\LoggerFormat\String("db_test") );


$db = new \pfc\SQL\ProfilerDecorator($real_db, new \pfc\Profiler() );
$db->setLogger($logger);

$cacheAdapterFile = new \pfc\CacheAdapter\Shm("sql_cache_");
$cacheAdapter     = new \pfc\CacheAdapter\GZipDecorator($cacheAdapterFile);

$serializer   = new \pfc\Serializer\JSON();

$db2 = new \pfc\SQL\CacheDecorator($db, $cacheAdapter, $serializer, 20 );
$db2->setLogger($logger);

