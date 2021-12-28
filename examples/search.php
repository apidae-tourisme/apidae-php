<?php

$config = [];
require __DIR__ . "/requires.inc.php";

$client = new \ApidaePHP\Client($config);

try {
    $res = $client->searchObject(['query' => ["searchQuery" => "vélo"]]);
    showResult($res, 'searchObject (' . $client->operations['searchObject']['uri'] . ')');
} catch (Exception $e) {
    echo $e;
}

try {
    $res = $client->searchObjectIdentifier(['query' => ["searchQuery" => "vélo"]]);
    showResult($res, 'searchObjectIdentifier (' . $client->operations['searchObjectIdentifier']['uri'] . ')');
} catch (Exception $e) {
    echo $e;
}
