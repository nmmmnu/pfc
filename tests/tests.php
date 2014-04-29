#!/usr/local/bin/php
<?
namespace pfc;
require_once "__autoload.php";

dl("dba.so");
pfc_assert_setup();

$redis_tests = false;
$slow_tests = false; // true;

//print_r(dba_handlers());



echo Info::COPYRIGHT() . "\n\n";



StringBuilder::test();



ArrayIterator::test();

KeysIteratorDecorator::test();

compat\PHP2Iterator::test();
compat\Iterator2PHP::test();

Iterators::test();



ArrayList::test();

Set::test();

ArraySet::test();



Serializer\NULLAdapter::test();
Serializer\PHP::test();
Serializer\JSON::test();

Serializer\GZipDecorator::test();



DBM::test();
DBMIterator::test();


if ($slow_tests){
	CacheAdapter\File::test();
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

