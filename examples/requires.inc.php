<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
$config = [];
if (preg_match('#vendor#', realpath(__FILE__))) die('This should not be exposed in vendor directory');

if (!file_exists(__DIR__ . "/../vendor/autoload.php")) die('no vendor autoload found...');
if (!file_exists(__DIR__ . "/../config.inc.php")) die('please copy/edit config.sample.php to config.inc.php');

require __DIR__ . "/../vendor/autoload.php";
require __DIR__ . "/../config.inc.php";
