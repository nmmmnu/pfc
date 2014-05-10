#!/usr/local/bin/php
<?
namespace pfc;
require_once __DIR__ . "/../__autoload.php";

error_reporting(E_ALL);


function err($type, $a, $b){
	trigger_error("shame on me", $type);
}


echo "--ErrorHandler\Development--\n";

( new ErrorHandler\Development(false) )->register();

err(E_USER_WARNING, "niki", 123);



echo "--ErrorHandler\Production--\n";

( new ErrorHandler\Production(false) )->register();

err(E_USER_WARNING, "niki", 123);
err(E_USER_ERROR, "niki", 123);

echo "--end--\n";

