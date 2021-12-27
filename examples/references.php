<?php

$config = [];
require __DIR__ . "/requires.inc.php";

$client = new \ApidaePHP\Client($config);

try {
    $res = $client->getReferenceCity(['query' => ['communeIds' => [36866]]]);
    showResult($res, 'getReferenceCity (' . $client->operations['getReferenceCity']['uri'] . ')');
} catch (Exception $e) {
    echo 'Exception : ' . PHP_EOL . $e->getMessage();
}
