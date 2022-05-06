<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
$config = [];
if (preg_match('#vendor#', realpath(__FILE__))) die('This should not be exposed in vendor directory');

if (!file_exists(__DIR__ . "/../vendor/autoload.php")) die('no vendor autoload found...');
if (!file_exists(__DIR__ . "/../config.inc.php")) die('please copy/edit config.sample.php to config.inc.php');

require __DIR__ . "/../vendor/autoload.php";
require __DIR__ . "/../config.inc.php";

function showResult(mixed $r, $h2 = null): void
{
    $html = php_sapi_name() !== 'cli';
    if ($html) {
        if ($h2 != null) echo '<h2>' . $h2 . '</h2>';
        if (isset($r['numFound'])) echo '<h3>' . $r['numFound'] . ' results (numFound)</h3>' . PHP_EOL;
        elseif (is_countable($r)) echo '<h3>' . count($r) . ' results (count)</h3>' . PHP_EOL;
        echo '<pre style="background:green;max-height:200px;overflow:scroll;color:white;padding:10px;font-size:.8em;">' . PHP_EOL;
        print_r($r);
        echo PHP_EOL . '</pre>' . PHP_EOL;
    } else {
        if ($h2 != null) echo PHP_EOL . '****** ' . $h2 . PHP_EOL;
        if (isset($r['numFound'])) echo $r['numFound'] . ' results (numFound)' . PHP_EOL;
        elseif (is_countable($r)) echo count($r) . ' results (count)' . PHP_EOL;
        if (is_array($r)) echo json_encode($r, JSON_PRETTY_PRINT);
        else print_r($r);
        echo PHP_EOL;
    }
}
