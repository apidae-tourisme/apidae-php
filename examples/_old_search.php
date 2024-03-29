<?php

$config = [];
require __DIR__ . "/requires.inc.php";

$client = new \ApidaePHP\Client($config);

echo "\n" . '<h1>References</h1>' . "\n";

echo "\n" . '<h2>getReferenceCity (' . $client->operations['getReferenceCity']['uri'] . ')</h2>' . "\n";
try {
    $res = $client->getReferenceCity(['query' => ['codesInsee' => ["38534", "69388", "74140"]]]);
    showResult($res);
} catch (Exception $e) {
    echo $e;
}

echo "\n" . '<h2>getReferenceElement (' . $client->operations['getReferenceElement']['uri'] . ')</h2>' . "\n";
try {
    $res = $client->getReferenceElement(['query' => ["elementReferenceIds" => [2, 118, 2338]]]);
    showResult($res);
} catch (Exception $e) {
    echo $e;
}

echo "\n" . '<h2>getReferenceInternalCriteria (' . $client->operations['getReferenceInternalCriteria']['uri'] . ')</h2>' . "\n";
try {
    $res = $client->getReferenceInternalCriteria(['query' => ["critereInterneIds" => [1068, 2168]]]);
    showResult($res);
} catch (Exception $e) {
    echo $e;
}

echo "\n" . '<h2>getReferenceSelection (' . $client->operations['getReferenceSelection']['uri'] . ')</h2>' . "\n";
try {
    $res = $client->getReferenceSelection(['query' => ["selectionIds" => [64, 5896]]]);
    showResult($res);
} catch (Exception $e) {
    echo $e;
}



echo "\n" . '<h1>Searchs</h1>' . "\n";

echo "\n" . '<h2>searchObject (' . $client->operations['searchObject']['uri'] . ')</h2>' . "\n";
try {
    $res = $client->searchObject(['query' => ["searchQuery" => "vélo"]]);
    showResult($res);
} catch (Exception $e) {
    echo $e;
}

echo "\n" . '<h2>searchObjectIdentifier (' . $client->operations['searchObjectIdentifier']['uri'] . ')</h2>' . "\n";
try {
    $res = $client->searchObjectIdentifier(['query' => ["searchQuery" => "vélo"]]);
    showResult($res);
} catch (Exception $e) {
    echo $e;
}

echo "\n" . '<h2>searchAgendaIdentifier (' . $client->operations['searchAgendaIdentifier']['uri'] . ')</h2>' . "\n";
try {
    $res = $client->searchAgendaIdentifier(['query' => ["searchQuery" => "vélo"]]);
    showResult($res);
} catch (Exception $e) {
    echo $e;
}

echo "\n" . '<h2>searchAgenda (' . $client->operations['searchAgenda']['uri'] . ')</h2>' . "\n";
try {
    $res = $client->searchAgenda(['query' => ["searchQuery" => "vélo"]]);
    showResult($res);
} catch (Exception $e) {
    echo $e;
}

echo "\n" . '<h2>searchDetailedAgendaIdentifier (' . $client->operations['searchDetailedAgendaIdentifier']['uri'] . ')</h2>' . "\n";
try {
    $res = $client->searchDetailedAgendaIdentifier(['query' => ["searchQuery" => "vélo"]]);
    showResult($res);
} catch (Exception $e) {
    echo $e;
}

echo "\n" . '<h2>searchDetailedAgenda (' . $client->operations['searchDetailedAgenda']['uri'] . ')</h2>' . "\n";
try {
    $res = $client->searchDetailedAgenda(['query' => ["searchQuery" => "vélo"]]);
    showResult($res);
} catch (Exception $e) {
    echo $e;
}
