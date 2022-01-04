<?php

$config = [];
require __DIR__ . "/requires.inc.php";

$client = new \ApidaePHP\Client($config);

try {
    $res = $client->searchAgendaIdentifier(['query' => ["searchQuery" => "vélo"]]);
    showResult($res, 'searchAgendaIdentifier (' . $client->operations['searchAgendaIdentifier']['uri'] . ')');
} catch (Exception $e) {
    echo 'Exception : ' . $e->getMessage() . PHP_EOL;
}

try {
    $res = $client->searchAgenda(['query' => ["searchQuery" => "vélo"]]);
    showResult($res, 'searchAgenda (' . $client->operations['searchAgenda']['uri'] . ')');
} catch (Exception $e) {
    echo 'Exception : ' . $e->getMessage() . PHP_EOL;
}

try {
    $res = $client->searchDetailedAgendaIdentifier(['query' => ["searchQuery" => "vélo"]]);
    showResult($res, 'searchDetailedAgendaIdentifier (' . $client->operations['searchDetailedAgendaIdentifier']['uri'] . ')');
} catch (Exception $e) {
    echo 'Exception : ' . $e->getMessage() . PHP_EOL;
}

try {
    $res = $client->searchDetailedAgenda(['query' => ["searchQuery" => "vélo"]]);
    showResult($res, 'searchDetailedAgenda (' . $client->operations['searchDetailedAgenda']['uri'] . ')');
} catch (Exception $e) {
    echo 'Exception : ' . $e->getMessage() . PHP_EOL;
}
