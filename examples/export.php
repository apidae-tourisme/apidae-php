<?php

$config = [];
require __DIR__ . "/requires.inc.php";

$client = new \ApidaePHP\Client($config);

/**
 * In a classical situation, Apidae should send an http request after every new export :
 *  - Nightly, daily, weekly or monthly depending on the project configuration
 *  - or every time user click on "Export exceptionnel", so this can happen anytime in a day : https://base.apidae-tourisme.com/diffuser/projet/XXXX#tab-operations-exceptionnelles
 * 
 * The notification is an http call on an url on your project configured in "Configuration technique" on your project :
 * https://base.apidae-tourisme.com/diffuser/projet/XXXX#tab-configuration-technique
 * 
 * When you receive the notification, just store it anywhere (database...) :
 * you should probably not make any treatment on the notification (because it's an http call that can have a short timeout).
 * 
 * In most cases, a cron is supposed to check if there is a new notification that require something on your side (extraction, indexation...)
 * This cron can be daily (prefer something after 6am GMT) or more frequent if you want to catch the exceptionnal exports that can happen during the day (manually triggered)
 * 
 * After your export/indexation, you have to notify Apidae that everything is correct on your side :
 * $client->confirmExport(['hash' => $exportNotification['urlConfirmation']]);
 * This will be displayed in Apidae so your client will know that the job is done on your side :
 * https://base.apidae-tourisme.com/diffuser/projet/XXXX#tab-dernieres-generations : "Etat : Généré et intégré"
 * 
 */

try {
    /*
     * Export
     */

    // Notifications come from a $_POST from Apidae
    // Please note that $exportNotification can be defined in ../config.inc.php for testing this demo
    // Here is an example of what a $_POST could contain
    /*
        $exportNotification = array(
            "statut" => "SUCCESS",
            "reinitialisation" => "false",
            "projetId" => "672",
            "urlConfirmation" => "https://api.apidae-tourisme.com/api/v002/export/confirmation?hash=672_20150106-1344_V4BjvT",
            "ponctuel" => "true",
            "urlRecuperation" => "https://export.apidae-tourisme.com/exports/672_20150106-1344_V4BjvT.zip",
        ); 
     */


    if (!isset($exportNotification)) {
        die('Please fill $exportNotification in examples/demo-export.php or config.inc.php');
    }

    /**
     * First we clean older tests
     */
    $client->cleanExportFiles();

    $exportFiles = $client->getExportFiles(['url' => $exportNotification['urlRecuperation']]);

    foreach ($exportFiles->name('objets_modifies-*') as $file) {
        echo $file->getRealpath() . "\n";

        // If you use XML (Apidae settings)
        //$xml = simplexml_load_string($file->getContents());
        //print_r($xml);

        // If you use JSON
        // $json = \GuzzleHttp\Utils::jsonDecode($file->getContents(), true);
        // print_r($json);
    }

    $confirmation = $client->confirmExport(['hash' => $exportNotification['urlConfirmation']]);
} catch (\ApidaePHP\Exception\ApidaeException $e) {
    echo $e->getMessage();
    echo "\n";
    echo $e->getPrevious()->getMessage();
}
