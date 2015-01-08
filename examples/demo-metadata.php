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
