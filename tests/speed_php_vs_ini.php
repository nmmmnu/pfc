#!/usr/local/bin/php
<?
namespace pfc;
require_once __DIR__ . "/../__autoload.php";

$max = 1000000;


$loader1 = new Framework\RegistryLoader\Dir(__DIR__ . "/config");
$loader2 = new Framework\RegistryLoader\INI(__DIR__ . "/ini");



$p = new Profiler();

$p->stop("start");

for($i=0; $i < $max; $i++)
	$loader1->load("array");

$p->stop("dir");

for($i=0; $i < $max; $i++)
	$loader2->load("mysql");

$p->stop("ini");

print_r($p->getData());
