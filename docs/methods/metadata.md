
# Metadata

[Full documentation](http://dev.apidae-tourisme.com/fr/documentation-technique/v2/metadonnees)

## List metadata

You can ask for metadata like this:

```php
// Only with the mandatory fields
$metadata = $client->getMetadata([
    'referenceId' => 123457, 
    'nodeId' => 'jolicode'
]);

// More detailed search
$metadata = $client->getMetadata([
    'referenceId' => 123457, 
    'nodeId' => 'jolicode', 
    'targetType' => 'membre'
]);

$metadata = $client->getMetadata([
    'referenceId' => 123457, 
    'nodeId' => 'jolicode', 
    'targetType' => 'membre', 
    'targetId' => 21
]);
```

## Delete metadata

In the same way, you can delete metadata:

```php
$client->deleteMetadata([
    'referenceId' => 123457, 
    'nodeId' => 'jolicode', 
    'targetType' => 'membre', 
    'targetId' => 21
]);

// Remove them all
$client->deleteMetadata([
    'referenceId' => 123457, 
    'nodeId' => 'jolicode'
]);
```

## Insert and update metadata

Metadata API accept a large number of formats, they are all supported by this client.

```php
// Simple way on "general" target
$client->putMetadata([
    'referenceId' => 123457,
    'nodeId' => 'jolicode',
    'metadata' => [
        'general' => '{"MyInfos": "Nice weather"}',
    ]
]);

// Simple, with a targetId of 21 on "membres" target
$client->putMetadata([
    'referenceId' => 123457,
    'nodeId' => 'jolicode',
    'metadata' => [
        'membres.membre_21' => '{"MyInfos": "Nice weather"}',
    ]
]);

// Multiple (notice the double JSON encoding)
$client->putMetadata([
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
```
