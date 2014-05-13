#!/usr/local/bin/php
<?
namespace pfc;
require_once __DIR__ . "/../__autoload.php";



require "db.php";



$profiler->stop("app factory");



// connect
echo "Connecting...\n";
var_dump($db->open());



$profiler->stop("db connect");



// prepare data, don't throw exceptions
$real_db->query("
	create table ppl(
		id int primary key,
		name varchar(20),
		age int
	)
", array());


$db->query("delete from ppl", array());

$db->query("insert into ppl values(%s, %s, %s)", array(1, 'Ivan',   22) );
$db->query("insert into ppl values(%s, %s, %s)", array(2, 'Stoyan', 25) );
$db->query("insert into ppl values(%s, %s, %s)", array(3, 'Dragan', 33) );
$db->query("insert into ppl values(%s, %s, %s)", array(4, 'James',  42) );



$profiler->stop("db populate");


// sql
$sql = "
	select
		*
	from
		ppl
	where
		id <> %s
";



// select
echo "\n---begin---\n";
echo "DB SQL:\n";

$rows = $db2->query($sql, array(22) );
print_r(\pfc\Iterators::toArray($rows));
echo "---end---\n";



// select
echo "\n---begin---\n";
echo "DB SQL with PK:\n";

$rows = $db2->query($sql, array(22), "name");
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

