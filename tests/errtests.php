#!/usr/local/bin/php
<?
namespace pfc;
require_once __DIR__ . "/../__autoload.php";

error_reporting(E_ALL);


function separator($s = ""){
	echo "\n\n\n";

	if ($s)
	echo "---" . $s . "---" . "\n";

	echo "================================================\n";
}


function err($type, $a, $b){
	trigger_error("shame on me", $type);
}



function tests($banner, $fail){
	separator("$banner, E_USER_WARNING");
	err(E_USER_WARNING, "niki", 123);

	separator("$banner, E_WARNING");
	file_get_contents("/dev/shm/nonexistent.txt");

	separator("$banner, @E_WARNING");
	@file_get_contents("/dev/shm/nonexistent.txt");

	if ($fail){
	separator("$banner, E_USER_ERROR");
	err(E_USER_ERROR, "niki", 123);
	}
}



( new ErrorHandler\Development(false, true) )->register();
tests("Development", false);


( new ErrorHandler\Production(false, true) )->register();
tests("Development", true);


separator("ErrorHandler\Production, E_USER_WARNING");
err(E_USER_WARNING, "niki", 123);


