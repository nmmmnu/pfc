#!/usr/local/bin/php
<?
namespace tests;
require_once __DIR__ . "/../__autoload.php";



$profiler = new \pfc\Profiler();



require "db.php";



$profiler->stop("app factory");



// connect
$dbfile = __DIR__ . "/../data/test.database.sqlite3";
$db->open("sqlite:$dbfile" );



$profiler->stop("db connect");



// prepare data
$x = $db->query("delete from ppl");
$x = $db->query("insert into ppl values(1, 'Ivan',   22)");
$x = $db->query("insert into ppl values(2, 'Stoyan', 25)");
$x = $db->query("insert into ppl values(3, 'Dragan', 33)");

echo "\n---begin---\n";
echo "DB prepare stats:\n";
printf("Affected rows %8d\n", $x->affectedRows());
printf("Insert ID     %8d\n", $x->insertID());
echo "---end---\n";



$profiler->stop("db populate");



// sql
$sql = sprintf(
	"
		select
			*
		from
			ppl
		where
			id <> %s
	",
		$db2->escape(20)
);


// select

echo "\n---begin---\n";
echo "DB SQL:\n";

$rows = $db2->query($sql);
print_r(\pfc\Iterators::toArray($rows));
echo "---end---\n";



// select

echo "\n---begin---\n";
echo "DB SQL with PK:\n";

$rows = $db2->query($sql, "name");
print_r(\pfc\Iterators::toArray($rows));
echo "---end---\n";



$profiler->stop("db select");



// close
$db2->close();



$profiler->stop("end");



echo "\n---begin---\n";
echo "Profiling:\n";
print_r($profiler->getData());
echo "---end---\n";

