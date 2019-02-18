<?php

// Include Composer autoload
require __DIR__."/../../../autoload.php";
require __DIR__."/../config.inc.php";

// Create the client
$client = new \Sitra\ApiClient\Client([
    'apiKey'        => $config['apiKey'],
    'projectId'     => $config['projectId'],
    'baseUrl'       => $config['baseUrl']
]);

try {
    /*
     * Export
     */

    // Notifications come from a $_POST from Apidae
    $exportNotification = array(
        "statut" => "SUCCESS",
        "reinitialisation" => "false",
        "projetId" => "672",
        "urlConfirmation" => "https://api.apidae-tourisme.com/api/v002/export/confirmation?hash=672_20150106-1344_V4BjvT",
        "ponctuel" => "true",
        "urlRecuperation" => "https://export.apidae-tourisme.com/exports/672_20150106-1344_V4BjvT.zip",
    );

    $exportFiles = $client->getExportFiles(['url' => $exportNotification['urlRecuperation']]);
    foreach ($exportFiles->name('objets_lies_modifies-14*') as $file) {
        var_dump($file->getRealpath());

        // If you use XML (Apidae settings)
        //$xml = simplexml_load_string($file->getContents());
        //print_r($xml);

        // If you use JSON
        // $json = \GuzzleHttp\Utils::jsonDecode($file->getContents(), true);
        // print_r($json);
    }

    $confirmation = $client->confirmExport(['hash' => $exportNotification['urlConfirmation']]);


    /*
     * Reference
     */
    $cities = $client->getReferenceCity(['query' => [ 'codesInsee' => ["38534", "69388", "74140"] ]]);
    var_dump(count($cities));

    $elements = $client->getReferenceElement(['query' => [ "elementReferenceIds" => [2, 118, 2338] ]]);
    var_dump(count($elements));

    $elements = $client->getReferenceInternalCriteria(['query' => [ "critereInterneIds" => [ 1068, 2168 ] ]]);
    var_dump(count($elements));

    $elements = $client->getReferenceSelection(['query' => [ "selectionIds" => [  64, 5896 ] ]]);
    var_dump(count($elements));
} catch (\Sitra\ApiClient\Exception\SitraException $e) {
    echo $e->getMessage();
    echo "\n";
    echo $e->getPrevious()->getMessage();
}
