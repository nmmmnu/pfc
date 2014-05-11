#!/usr/local/bin/php
<?
namespace pfc;
require_once __DIR__ . "/../__autoload.php";


pfc_assert_setup();


error_reporting(E_ALL);
( new ErrorHandler\Development($html = false, $suppress = true) )->register();


$redis_tests = false || true;
$slow_tests = false  ;//|| true;


echo Info::COPYRIGHT() . "\n\n";


ArrayList::test();


StringBuilder::test();


KeysIterator::test();
IteratorIterator::test();


Iterators::test();


Profiler::test();


HTTPResponse::test();


Serializer\PHP::test();
Serializer\JSON::test();


OutputAdapter\File::test();
OutputAdapter\Console::test();
OutputAdapter\Addable::test();
OutputAdapter\PHP::test();


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


UnitTests\CallbackTests::test();
UnitTests\CallbackCollectionTests::test();


Framework\Path\Exact::test();
Framework\Path\CatchAll::test();
Framework\Path\Mask::test();


UnitTests\RouterTests::test();


RegistryLoader\Dir::test();
RegistryLoader\INI::test();

Registry::test();





echo "All tests passed!!!\n";
echo "You are awesome :)\n";

exit(0);

