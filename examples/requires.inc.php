<?php

if (preg_match('#vendor#', realpath(__FILE__))) die('This should not be exposed in vendor directory');

if (file_exists(__DIR__ . "/../vendor/autoload.php")) {
    require __DIR__ . "/../vendor/autoload.php";
    require __DIR__ . "/../config.inc.php";
} else
    die('no vendor autoload found...');
