#!/usr/local/bin/php
<?
namespace pfc;
require_once "__autoload.php";

pfc_assert_setup();

$redis_tests = false || true;
$slow_tests = false || true;


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



echo "All tests passed!!!\n";
echo "You are awesome :)\n";

exit(0);

