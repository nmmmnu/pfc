<?
namespace tests;

$real_db = new \pfc\SQL\PDO();

$db = new \pfc\SQL\ProfilerDecorator($real_db, new \pfc\Profiler());
$db->setDebug(true);

$cacheAdapter = new \pfc\CacheAdapter\Shm("sql_cache_");
$serializer   = new \pfc\Serializer\GZipDecorator( new \pfc\Serializer\JSON() );

$db2 = new \pfc\SQL\CacheDecorator($db, $cacheAdapter, $serializer, 20 );
$db2->setDebug(true);
