# Sitra PHP Api Client

PHP Client for Rhône Alpes Tourisme [Sitra API](http://www.sitra-rhonealpes.com/) based on Guzzle 5.

- Authentication set automatically (for both credentials and OAuth end points);
- All API methods exposed with input validation;
- Error handling;

This documentation only handle the PHP implementation, for further questions please refer 
to [Sitra API Documentation](http://www.sitra-rhonealpes.com/wiki/index.php/API_Sitra_2).

## Install

### Via Composer

    composer require sitra-tourisme/sitra-api-php dev-master
    
### Standalone (when you can't use Composer)

If you can't use Composer, please follow those steps to install and use the library:

- Go to https://composer.borreli.com/, paste this JSON and download the ZIP:
```json
{
    "require": { "sitra-tourisme/sitra-api-php": "dev-master" }
}
```
- Extract the ZIP file and add the whole "vendor" directory to your project;
- Include the file `vendor/autoload.php` if you do not have an autoloader already.

However we **strongly** encourage you to [use Composer](https://getcomposer.org/) on all your projects.

## Usage

### Creating a Client

You need to create a `Client` instance:

```php
$client = new \Sitra\ApiClient\Client([
    'apiKey'        => 'XXX',
    'projectId'     => 672,
    'baseUrl'       => 'http://api.sitra-tourisme.com/',
    'OAuthClientId' => 'XXX',
    'OAuthSecret'   => 'XXX',
]);
```

This class is stateless and can be used as a service. You can then call any method directly:

```php
$metadata = $client->getMetadata(['referenceId' => 123457, 'nodeId' => 'jolicode']);
$search = $client->searchDetailedAgenda(['query' => '{"searchQuery": "vélo"}']);
$search = $client->searchObject(['query' => '{"searchQuery": "vélo"}']);
$object = $client->getObjectById(['id' => 163512]);
```

Result is always a decoded PHP Array.

#### Options

- `apiKey`: Project API Key;
- `projectId`: Corresponding projectId;
- `baseUrl`: Not mandatory, useful if you want to hit pre-production i.e.;
- `OAuthClientId`: Only for Metadata, a valid OAuth Client Id;
- `OAuthSecret`: Only for Metadata, the corresponding secret.

#### Handling errors

We recommend that all API calls are done in a try block.

##### API Errors

Errors from the API are wrapped in `Sitra\ApiClient\Exception\SitraException`.

```php
try {
    $cities = $client->getReferenceCity(['query' => '{"codesInsee": ["38534", "69388", "74140"]}']);
} catch (\Sitra\ApiClient\Exception\SitraException $e) {
    echo $e->getMessage();
}
```

The Exception message is **not** for public display as it may contains credentials.

##### Validation Errors

Validations errors happens before the query and assume you did not respect the defined schema for a method.

They are represent by `GuzzleHttp\Command\Exception\CommandException`.

##### Metadata Errors

The JSON used for metadata editing is complex and come with his own Exception `Sitra\ApiClient\Exception\InvalidMetadataFormatException`.

## API methods

### Read Touristic Objects

#### Get by Id

```php
$object = $client->getObjectById(['id' => 163512]);
```

#### Get by Identifier

```php
$object = $client->getObjectByIdentifier(['identifier' => 'sitraSKI275809']);
```

### Search Touristic Objects

Search queries accept a JSON formatted search object that must contain your API credentials, 
by using this client, you can send only the search related fields in your JSON and we will add automatically the 
appropriate fields if absent.

#### List search results

You can send search in a couple of ways:

```php
// As JSON string
$search = $client->searchObject(['query' => '{"searchQuery": "vélo"}']);

// As PHP Array
$search = $client->searchObject(['query' => [
    "searchQuery" => "vélo",
    "count" => 20,
    "first" => 10,
]]);

// With the credentials it works too (but we handle them for you)
$search = $client->searchObject(['query' => [
    "searchQuery" => "vélo"
    "apiKey" => 'XXX',
    "projetId" => 1,
]]);
```

#### Search with identifier

When you only need the object ids:

```php
$client->searchObjectIdentifier(['query' => '{"searchQuery": "vélo"}']);
```

### Agenda

Like normal search, you do not need to provide the API credentials to use those methods.

#### List search agenda results

```php
$client->searchAgenda(['query' => '{"searchQuery": "vélo"}']);
```

#### Search agenda with identifier

```php
$client->searchAgendaIdentifier(['query' => '{"searchQuery": "vélo"}']);
```

#### List search agenda results with detailed view

```php
$client->searchDetailedAgenda(['query' => '{"searchQuery": "vélo"}']);
```

#### Search agenda with identifier with detailed view

```php
$client->searchDetailedAgendaIdentifier(['query' => '{"searchQuery": "vélo"}']);
```

### Metadata

#### List metadata

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

#### Delete metadata

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

#### Insert and update metadata

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

### Reference

Like normal search, you do not need to provide the API credentials to use those methods.

#### Cities

```php
$cities = $client->getReferenceCity([
    'query' => '{"codesInsee": ["38534", "69388", "74140"]}'
]);
```

#### Elements

```php
$elements = $client->getReferenceElement([
    'query' => '{"elementReferenceIds": [2, 118, 2338]}'
]);
```

#### Internal Criteria

```php
$criteria = $client->getReferenceInternalCriteria([
    'query' => '{"critereInterneIds":[1068, 2168]}'
]);
```

#### Selections

```php
$selections = $client->getReferenceSelection([
    'query' => '{"selectionIds":[64, 5896]}'
]);
```

### Exports

*This feature require the PHP Zip extension and write permission on the filesystem.*

Exports are an asynchronous feature of Sitra allowing you to retrieve a large quantity of data without 
performing a lot of API calls. When a new export is done via Sitra and ready to take care,
your application receive a notification which looks like this:

```php
$exportNotification = $_POST;

// What Sitra sends:
array(
    "statut" => "SUCCESS",
    "reinitialisation" => "false",
    "projetId" => "672",
    "urlConfirmation" => "http://api.sitra-tourisme.com/api/v002/export/confirmation?hash=XXX",
    "ponctuel" => "true",
    "urlRecuperation" => "http://export.sitra-tourisme.com/exports/XXX.zip",
);
```

You **must** store those information and answer Sitra as soon as possible with a success response.

Then, to handle this export, you need to:

1. download the export in a memory efficient way;
1. extract the files locally;
1. do your own logic about what you need;
1. and if everything is OK, you must call "urlConfirmation".

The library handle the first two points and the last one.

#### Download and extract export

Simply call the `getExportFiles` method and provide the `urlRecuperation`:

```php
$exportFiles = $client->getExportFiles([
    'url' => $exportNotification['urlRecuperation']
]);
```

`$exportFiles` is then a [`Finder`](http://symfony.com/doc/current/components/finder.html) object you can iterate on:

```php
// Get all the files and display their content
foreach ($exportFiles->files() as $file) {
    echo $file->getRealpath();
    echo '<br>';
    echo $file->getContents();
    echo '<br>';
}

// Filter files by name...
foreach ($exportFiles->name('objets_lies_modifies-14*') as $file) {
    echo $file->getRealpath();
}
```

#### Confirmation

When you have finished your tasks, you must confirm to Sitra that everything went fine.

```php
// With the export hash
$client->confirmExport(['hash' => 'XXX']);

// Or, with the full URL given in the notification
$client->confirmExport(['hash' => $exportNotification['urlConfirmation']]);
```

*You may also use the `$exportFiles` iterator to remove files from your server filesystem after usage.*

### Todo

- Allow configuration tweak (curl timeout? proxy?)
- Export download directory should be configurable
- Fix all @todo
- Add some documentation about switching the HTTP client?
- SSO integration
- Tag the first release
