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

try {
    $res = $client->getReferenceSelectionsByObject(['query' => ['referenceIds' => [4882168]]]);
    showResult($res, 'getReferenceSelectionsByObject (' . $client->operations['getReferenceSelectionsByObject']['uri'] . ')');
} catch (Exception $e) {
    echo 'Exception : ' . PHP_EOL . $e->getMessage();
}



/**
 * @todo vérifier les tests ci-dessous
 */


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
