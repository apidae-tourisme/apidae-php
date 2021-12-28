<?php

$config = [];
require __DIR__ . "/requires.inc.php";

$client = new \ApidaePHP\Client($config);

try {
    $res = $client->getObjectById(['id' => 163512]);
    showResult($res, 'getObjectById (' . $client->operations['getObjectById']['uri'] . ')');
} catch (Exception $e) {
    echo $e;
}

try {
    $res = $client->getObjectByIdentifier(['identifier' => 'oldSKI275809']);
    showResult($res, 'getObjectByIdentifier (' . $client->operations['getObjectByIdentifier']['uri'] . ')');
} catch (Exception $e) {
    echo $e;
}
