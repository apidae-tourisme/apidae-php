<?php

// Include Composer autoload
include __DIR__."/../vendor/autoload.php";

// Create the client
$client = new \Sitra\ApiClient\Client([
    'apiKey'        => 'XXX',
    'projectId'     => 000,
    'baseUrl'       => 'http://api.sitra-tourisme.com/',
    'OAuthClientId' => 'XXX',
    'OAuthSecret'   => 'XXX',
]);

try {
    // Can come from a $_POST
    $exportNotification = array(
        "statut" => "SUCCESS",
        "reinitialisation" => "false",
        "projetId" => "672",
        "urlConfirmation" => "http://api.sitra-tourisme.com/api/v002/export/confirmation?hash=672_20150106-1344_V4BjvT",
        "ponctuel" => "true",
        "urlRecuperation" => "http://export.sitra-tourisme.com/exports/672_20150106-1344_V4BjvT.zip",
    );


    $exportFiles = $client->getExportFiles(['url' => $exportNotification['urlRecuperation']]);
    foreach ($exportFiles->name('objets_lies_modifies-14*') as $file) {
        var_dump($file->getRealpath());
    }

    $confirmation = $client->confirmExport(['hash' => $exportNotification['urlConfirmation']]);

    $cities = $client->getReferenceCity(['query' => '{"codesInsee": ["38534", "69388", "74140"]}']);
    var_dump(count($cities));

    $elements = $client->getReferenceElement(['query' => '{"elementReferenceIds": [2, 118, 2338]}']);
    var_dump(count($elements));

    $elements = $client->getReferenceInternalCriteria(['query' => '{"critereInterneIds":[ 1068, 2168 ]}']);
    var_dump(count($elements));

    $elements = $client->getReferenceSelection(['query' => '{"selectionIds":[  64, 5896 ]}']);
    var_dump(count($elements));

    $search = $client->searchObject(['query' => '{"searchQuery": "vélo"}']);
    var_dump($search['numFound']);

    $search = $client->searchObjectIdentifier(['query' => '{"searchQuery": "vélo"}']);
    var_dump($search['numFound']);

    $search = $client->searchAgendaIdentifier(['query' => ["searchQuery" => "vélo"]]);
    $search = $client->searchAgendaIdentifier(['query' => '{"searchQuery": "vélo"}']);
    var_dump($search['numFound']);
    $search = $client->searchAgenda(['query' => '{"searchQuery": "vélo"}']);
    var_dump($search['numFound']);

    $search = $client->searchDetailedAgendaIdentifier(['query' => '{"searchQuery": "vélo"}']);
    var_dump($search['numFound']);

    $search = $client->searchDetailedAgenda(['query' => '{"searchQuery": "vélo"}']);
    var_dump($search['numFound']);

    $object = $client->getObjectById(['isd' => 163512]);
    var_dump($object['id']);

    $object = $client->getObjectByIdentifier(['identifier' => 'sitraSKI275809']);
    var_dump($object['id']);

    $metadata = $client->getMetadata(['referenceId' => 123457, 'nodeId' => 'jolicode']);
    var_dump($metadata['identifiant']);

    $metadata = $client->putMetadata([
        'referenceId' => 123457,
        'nodeId' => 'jolicode',
        'metadata' => [
            'general' => '{"infoGenerale":"Mise à jour le '.date('Y-m-d H:i:s').'"}',
        ]
    ]);

    $metadata = $client->getMetadata(['referenceId' => 123457, 'nodeId' => 'jolicode']);
    var_dump($metadata['identifiant']);

    $metadata = $client->putMetadata([
        'referenceId' => 123457,
        'nodeId' => 'jolicode',
        'metadata' => [
            'membres.membre_21' => '{"projet test":"Mise à jour le '.date('Y-m-d H:i:s').'"}',
        ]
    ]);

    $metadata = $client->getMetadata(['referenceId' => 123457, 'nodeId' => 'jolicode', 'targetType' => 'membre', 'targetId' => 21]);
    var_dump($metadata['identifiant']);

    $metadata = $client->deleteMetadata(['referenceId' => 123457, 'nodeId' => 'jolicode', 'targetType' => 'membre', 'targetId' => 21]);
    var_dump($metadata);

    $metadata = $client->getMetadata(['referenceId' => 123457, 'nodeId' => 'jolicode', 'targetType' => 'membre', 'targetId' => 21]);
    var_dump($metadata);

    $metadata = $client->putMetadata([
        'referenceId' => 123457,
        'nodeId' => 'jolicode',
        'metadata' => [
            'node' => json_encode([
                'general' => json_encode(['toto' => true, 'foo' => 'bar']),
                'membres' => ([
                    ['targetId' => 111, 'jsonData' => json_encode(['foo' => 'barbar'])]
                ]),
            ])
        ]
    ]);

    $metadata = $client->putMetadata([
        'referenceId' => 123457,
        'nodeId' => 'jolicode',
        'metadata' => [
            'membres' => '[{"targetId": 21, "jsonData": "{ \"foo\": \"bar\", \"bar\": 691 }" }, { "targetId": 12, "jsonData": "{ \"bar\": \"foo\" }" } ]'
        ]
    ]);

    $metadata = $client->getMetadata(['referenceId' => 123457, 'nodeId' => 'jolicode', 'targetType' => 'membre']);
    var_dump($metadata);
} catch (\Sitra\ApiClient\Exception\SitraException $e) {
    echo $e->getMessage();
    echo "\n";
    echo $e->getPrevious()->getMessage();
}
