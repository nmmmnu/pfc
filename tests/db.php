<?
namespace tests;

$real_db = new \pfc\SQL\PDO();

$db = new \pfc\SQL\ProfilerDecorator($real_db, new \pfc\Profiler());
$db->setDebug(true);

$cacheAdapterFile = new \pfc\CacheAdapter\Shm("sql_cache_");
$cacheAdapter     = new \pfc\CacheAdapter\GZipDecorator($cacheAdapterFile);

$serializer   = new \pfc\Serializer\JSON();

$db2 = new \pfc\SQL\CacheDecorator($db, $cacheAdapter, $serializer, 20 );
$db2->setDebug(true);
