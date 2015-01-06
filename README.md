# Sitra PHP Api Client

PHP Client for Rhône Alpes Tourisme [Sitra API](http://www.sitra-rhonealpes.com/) based on Guzzle 5.

- Authentication set automatically (for both credentials and OAuth end points);
- All API methods exposed with input validation;
- Error handling;

This documentation only handle the PHP implementation, for further questions please refer 
to [Sitra API Documentation](http://www.sitra-rhonealpes.com/wiki/index.php/API_Sitra_2).

## Install

### Via Composer (not yet available)

    composer require sitra-tourisme/sitra-api-php
    
### Standalone (when you can't use Composer)

Todo (make use of https://composer.borreli.com/ ?)

## Usage

### Creating a Client

Todo config
OAuth only need for Metadata.

### Read Touristic Objects

todo

### Metadata

#### List metadata

You can ask for metadata like this:

```php
$metadata = $client->getMetadata([
    'referenceId' => 123457, 
    'nodeId' => 'jolicode'
]);

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

### Exports

*This feature require the PHP ZIP extension.*

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

1. download the export;
1. extract the files;
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
$client->confirmExport(['hash' => 'XXX']);

// Or, with the full URL given in the notification
$client->confirmExport(['hash' => $exportNotification['urlConfirmation']]);
```

*You may also use the `$exportFiles` iterator to remove files from your server filesystem after usage.*

### Todo

- How to call any method
- How to tweak (switch Curl by another client)
- How to catch errors
- How to use Exports...

### Todo implementation

- Sitra error wrapping
- SSO integration
- Export
 - Exemple of notification end-point?
 - Call of the confirmation URL
- Finish all touristic methods
