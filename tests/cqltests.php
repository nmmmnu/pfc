#!/usr/local/bin/php
<?
namespace pfc;

require_once __DIR__ . "/../__autoload.php";
require_once __DIR__ . "/../__cassandra_autoload.php";


$connection = array(
	"hosts"		=> array(
				"office-server.cosm:9160"	,
				"office-server.com:9160"	,
			),
	"keyspace"	=> "niki"				,
	"primary_key"	=> "_PK_"
);


$db = new SQL\CQL($connection);

if (! $db->open() ){
	echo "can not connect\n";
	exit;
}

// Insert
$data = $db->query("
	insert into users(
		user_id,
		name
	)values(
		'%s',
		'%s'
	)
", array(
		"stoyan",
		"Stoyan's"
), "_KEY_");

print_r($data->fetchArray());

// Select

$data = $db->query("select * from users", array());

print_r($data->fetchArray());





