# Apidae PHP Api Client (formerly known as Sitra)

PHP Client for Rhône Alpes Tourisme [Apidae API](http://blog.apidae-tourisme.com/)

- All API methods exposed with input validation;
- Authentication set automatically (for both credentials and OAuth end points);
- Apidae SSO helpers;
- Error handling;
- Handle exports (Zip download and reading);
- Based on Guzzle 5.

This documentation only handle the PHP implementation, for further questions please refer 
to [Apidae API Documentation](http://dev.apidae-tourisme.com/).

## Install

### Via Composer

    composer require sitra-tourisme/sitra-api-php
    
### Standalone (when you can't use Composer)

If you can't use Composer:

- You can download a full archive [here](http://dev.apidae-tourisme.com/wp-content/uploads/2015/03/sitra-api-php-1-0.zip)
  - Extract the ZIP file and add the whole "vendor" directory to your project;
  - Include the file `vendor/autoload.php` if you do not have an autoloader already.

- Or, if you already use an autoloader, please follow those steps:
  - Go to https://composer.borreli.com/, paste this JSON and download the ZIP:
```json
{
    "require": { "sitra-tourisme/sitra-api-php": "@stable" }
}
```
  - Extract the ZIP file and add the whole "vendor" directory to your project;

However we **strongly** encourage you to [use Composer](https://getcomposer.org/) on all your projects.

## Usage

### Creating a Client

You need to create a `Client` instance:

```php
$client = new \Sitra\ApiClient\Client([
    'apiKey'           => 'XXX',
    'projectId'        => 672,
    'baseUrl'          => 'http://api.sitra-tourisme.com/',
    'OAuthClientId'    => 'XXX',
    'OAuthSecret'      => 'XXX',
    'exportDir'        => '/tmp/sitraExports',

    // Http client configuration
    'timeout'          => 0,
    'connectTimeout'   => 0,
    'proxy'            => null,
    'verify'           => true,

    // Global settings for touristic objects queries
    'responseFields'   => [],
    'locales'          => ['fr', 'en'],
    'count'            => 20,

    // For SSO
    'ssoBaseUrl'       => 'http://base.sitra-tourisme.com',
    'ssoRedirectUrl'   => 'http://localhost/',
    'ssoClientId'      => 'XXX',
    'ssoSecret'        => 'XXX',
]);

// You can also only use the mandatory parameters (all options have sensible defaults).
$client = new \Sitra\ApiClient\Client([
    'apiKey'           => 'XXX',
    'projectId'        => 672,
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
- `OAuthSecret`: Only for Metadata, the corresponding secret;
- `exportDir`: The directory where we store and extract ZIP exports;
- `timeout`: Float describing the timeout of the request in seconds;
- `connectTimeout`: Float describing the number of seconds to wait while trying to connect to the server;
- `proxy`: [String or array to specify](http://guzzle.readthedocs.org/en/latest/clients.html#proxy) an HTTP proxy (like `http://username:password@192.168.16.1:42`);
- `verify`: [Boolean or string to describe](http://guzzle.readthedocs.org/en/latest/request-options.html#verify) the SSL certificate verification behavior of a request;
- `responseFields`: Allow to filter the fields returned globally for all object related queries ([documentation](http://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/filtrage-des-donnees));
- `locales`: Allow to filter the locales returned globally for all object related queries ([documentation](http://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/filtrage-des-langues));
- `count`: Allow to change the number of results globally for all object related queries;
- `ssoBaseUrl`: Base URL for SSO authentication ([documentation](http://dev.apidae-tourisme.com/fr/documentation-technique/v2/oauth/single-sign-on));
- `ssoRedirectUrl`: The URL where SSO user will be sent back in your application;
- `ssoClientId`: The SSO OAuth client ID;
- `ssoSecret`: The SSO OAuth client secret.

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

[Full documentation](http://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002objet-touristiqueget-by-id)

```php
$object = $client->getObjectById(['id' => 163512]);
```

#### Get by Identifier

[Full documentation](http://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002objet-touristiqueget-by-identifier)

```php
$object = $client->getObjectByIdentifier(['identifier' => 'sitraSKI275809']);
```

### Search Touristic Objects

- [Full request documentation](http://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/format-des-recherches)
- [Response format documentation](http://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/formats-de-reponse)

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

- [Full request documentation](http://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/format-des-recherches)
- [Response format documentation](http://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/formats-de-reponse)

#### List search agenda results

```php
$client->searchAgenda(['query' => '{"searchQuery": "vélo"}']);

$client->searchAgenda(['query' => '{"searchQuery": "vélo", "count": 88, "responseFields": ["nom"]}']);
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

[Full documentation](http://dev.apidae-tourisme.com/fr/documentation-technique/v2/metadonnees)

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

[Full documentation](http://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services#referentiel)

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

[Full documentation](http://dev.apidae-tourisme.com/fr/documentation-technique/v2/exports)

*This feature require the PHP Zip extension and write permission on the filesystem.*

Exports are an asynchronous feature of Apidae allowing you to retrieve a large quantity of data without 
performing a lot of API calls. When a new export is done via Apidae and ready to take care,
your application receive a notification which looks like this:

```php
$exportNotification = $_POST;

// What Apidae sends:
array(
    "statut" => "SUCCESS",
    "reinitialisation" => "false",
    "projetId" => "672",
    "urlConfirmation" => "http://api.sitra-tourisme.com/api/v002/export/confirmation?hash=XXX",
    "ponctuel" => "true",
    "urlRecuperation" => "http://export.sitra-tourisme.com/exports/XXX.zip",
);
```

You **must** store those information and answer Apidae as soon as possible with a success response.

Then, to handle this export, you need to:

1. download the export in a memory efficient way;
1. extract the files locally;
1. do your own logic about what you need;
1. and if everything is OK, you must call "urlConfirmation".

The library handle the first two points and the last one for you!

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

// Decode file contents (XML or JSON, see your Apidae settings)
foreach ($exportFiles->files() as $file) {
    // $xml = simplexml_load_string($file->getContents());
    // print_r($xml);

    $json = \GuzzleHttp\Utils::jsonDecode($file->getContents(), true);
    print_r($json);
}
```

#### Confirmation

When you have finished your tasks, you must confirm to Apidae that everything went fine.

```php
// With the export hash
$client->confirmExport(['hash' => 'XXX']);

// Or, with the full URL given in the notification
$client->confirmExport(['hash' => $exportNotification['urlConfirmation']]);
```

#### Cleaning up files

All the files are downloaded and extracted in the `exportDir` directory (see options).

We provide a method to clean this directory after you have done your business logic with the files:

```php
$client->cleanExportFiles();
```

### Using the SSO

[Full documentation](http://dev.apidae-tourisme.com/fr/documentation-technique/v2/oauth)

You must configure your client with the SSO options ('ssoRedirectUrl', 'ssoClientId' and 'ssoSecret' at least), 
then forward your user to the Apidae authorization URL. The user can then give your application the permission 
to access his data and will be redirected on your application with a code. This code is used to get an Access Token.

```php
$client = new \Sitra\ApiClient\Client([
    'ssoRedirectUrl' => 'http://example.com/TODO',
    'ssoClientId'    => 'XXX',
    'ssoSecret'      => 'XXX',
]);

<a href="<?php echo $client->getSsoUrl() ?>">Ask for auth code</a>
```

Your redirect page must listen for a "code" GET parameter:

```php
if (isset($_GET['code']) && !empty($_GET['code'])) {
    // The redirect URL get a "code", we use it to ask for a token
    $token = $client->getSsoToken(['code' => $_GET['code'], 'redirect_uri' => 'http://example.com/TODO']);

    // Store the new token in the client, will be used automatically!
    $client->setAccessToken($token['scope'], $token['access_token']);
}
```

You can persist the "scope" and "access_token" in your application session and set it back on the Client with 
the `$client->setAccessToken($token['scope'], $token['access_token']);` line.

You can then use API related to the users (`sso` scope).

#### Get profile information

```php
$profile = $client->getUserProfile();
```

#### Get touristic object user permissions

```php
$permissions = $client->getUserPermissionOnObject(['id' => 123457]);
```

### Cookbook

#### Make it works without CURL

If you can't install CURL on your servers, [please read this Guzzle FAQ answer and fear not](http://guzzle.readthedocs.org/en/latest/faq.html#does-guzzle-require-curl).

Guzzle provide a `StreamHandler` based on [PHP HTTP wrappers](http://php.net/manual/en/wrappers.http.php),
and will use it automatically if the CURL extension is not loaded.

### Todo

- SSO integration: make sure the scopes are not mixed-up
- Tag the first stable 1.0 release

#### Optional / Nice to have

- Raml or swagger export?
- Strong configuration validator (Config component)
