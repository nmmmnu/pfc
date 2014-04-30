#!/usr/local/bin/php
<?
namespace pfc;
require_once "__autoload.php";

pfc_assert_setup();

$redis_tests = false;
$slow_tests = false || true;




echo Info::COPYRIGHT() . "\n\n";



StringBuilder::test();



ArrayIterator::test();

KeysIteratorDecorator::test();



//Iterators::test();



Serializer\NULLAdapter::test();
Serializer\PHP::test();
Serializer\JSON::test();




if ($slow_tests){
	CacheAdapter\Shm::test();
	CacheAdapter\GZipDecorator::test();
	if ($redis_tests)
	CacheAdapter\Redis::test();
}


OutputAdapter\Console::test();
OutputAdapter\Addable::test();



SQL\Mock::test();



Authenticator\AllowAll::test();
Authenticator\DenyAll::test();
Authenticator\ArrayPassword::test();



Template\PHP::test();
Template\CacheDecorator::test();



echo "All tests passed!!!\n";
echo "You are awesome :)\n";

exit(0);

