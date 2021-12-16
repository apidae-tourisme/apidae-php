<?php

$config = [];
require __DIR__ . "/requires.inc.php";

$client = new \ApidaePHP\Client($config);

/**
 * Fill with some offers ID
 * Key is the offer ID
 * Value is the expected result
 * The exemples below should be edited depending on your project owner (default expected results are meant for member 1157 / Apidae Tourisme)
 */
$offers = [
    5163353 => 'Offer owned by project manager : Should be allowed',
    5023027 => 'Offer masqued, but owned by project manager : Should be allowed',
    1 => 'Offer does not exist : 404 / Exception',
];

echo '<pre>';

foreach ($offers as $offer => $expected) {
    echo $offer . ' expected : ' . $expected . "\n";
    try {
        $response = $client->getEditAutorisation(['id' => $offer]);
        echo $response['response']->getContents();
    } catch (Exception $e) {
        echo $e;
    }
    echo "\n" . '<hr />' . "\n";
}
