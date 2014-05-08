#!/usr/local/bin/php
<?
namespace pfc;
require_once __DIR__ . "/../__autoload.php";

error_reporting(E_ALL);

pfc_assert_setup();

$redis_tests = false || true;
$slow_tests = false;// || true;


echo Info::COPYRIGHT() . "\n\n";


ArrayList::test();


StringBuilder::test();


KeysIterator::test();
IteratorIterator::test();


Iterators::test();


Serializer\PHP::test();
Serializer\JSON::test();


OutputAdapter\File::test();
OutputAdapter\Console::test();
OutputAdapter\Addable::test();


Authenticator\AllowAll::test();
Authenticator\DenyAll::test();
Authenticator\ArrayPassword::test();


Compressor\GZip::test();
Compressor\GZDeflate::test();
Compressor\ZLib::test();


SQL\Mock::test();


if ($slow_tests){
	CacheAdapter\File::test();
	CacheAdapter\Shm::test();
	CacheAdapter\CompressorDecorator::test();
	if ($redis_tests)
	CacheAdapter\Redis::test();
}


Template\PHP::test();
Template\CacheDecorator::test();


CallbackToolsTests::test();



Framework\Route\Exact::test();
Framework\Route\CatchAll::test();
Framework\Route\Mask::test();


Framework\RouterTests::test();


echo "All tests passed!!!\n";
echo "You are awesome :)\n";

exit(0);

