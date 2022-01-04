<?php

$config = [];
require __DIR__ . "/requires.inc.php";

$client = new \ApidaePHP\Client($config);

try {
    $res = $client->referentielCommunes(['query' => ['communeIds' => [36866]]]);
    showResult($res, 'referentielCommunes (' . $client->getOperation('referentielCommunes')->getUri() . ')');
} catch (Exception $e) {
    echo 'Exception : ' . PHP_EOL . $e->getMessage();
}

try {
    $res = $client->referentielSelectionsParObjet(['query' => ['referenceIds' => [4882168]]]);
    showResult($res, 'referentielSelectionsParObjet (' . $client->getOperation('referentielSelectionsParObjet')->getUri() . ')');
} catch (Exception $e) {
    echo 'Exception : ' . PHP_EOL . $e->getMessage();
}

try {
    $res = $client->referentielElementsReference(['query' => ["elementReferenceIds" => [2, 118, 2338]]]);
    showResult($res, 'referentielElementsReference (' . $client->getOperation('referentielElementsReference')->getUri() . ')');
} catch (Exception $e) {
    echo 'Exception : ' . PHP_EOL . $e->getMessage();
}

try {
    $res = $client->referentielCriteresInternes(['query' => ["critereInterneIds" => [1068, 2168]]]);
    showResult($res, 'referentielCriteresInternes (' . $client->getOperation('referentielCriteresInternes')->getUri() . ')');
} catch (Exception $e) {
    echo 'Exception : ' . PHP_EOL . $e->getMessage();
}

try {
    $res = $client->referentielSelections(['query' => ["selectionIds" => [64, 5896]]]);
    showResult($res, 'referentielSelections (' . $client->getOperation('referentielSelections')->getUri() . ')');
} catch (Exception $e) {
    echo 'Exception : ' . PHP_EOL . $e->getMessage();
}
