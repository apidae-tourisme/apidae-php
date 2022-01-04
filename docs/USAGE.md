# Usage

## Creating a Client

You need to create a `Client` instance:

```php

// You can use only the mandatory parameters for reading projects (all other options have sensible defaults).
$client = new \ApidaePHP\Client([
    'apiKey'           => 'XXX',
    'projetId'        => 672,
]);

```

This class is stateless and can be used as a service. You can then call any method directly:

```php
$metadata = $client->getMetadata(['referenceId' => 123457, 'nodeId' => 'jolicode']);
$search = $client->searchDetailedAgenda(['query' => ['searchQuery' => 'vélo']]);
$search = $client->searchObject(['query' => ['searchQuery'] => 'vélo']]);
$object = $client->getObjectById(['id' => 163512]);
```

Result is always a decoded PHP Array.

## Options

- `apiKey`: REQUIRED : Project API Key;
- `projetId`: REQUIRED : Corresponding projetId;
- `baseUri`: Not mandatory, useful if you want to hit test environment i.e. https://api.apidae-tourisme.cooking/;
- `metaClientId`: Only for Metadata, a valid OAuth Client Id;
- `metaSecret`: Only for Metadata, the corresponding secret;
- `editClientId`: Only for Touristic objects edit, a valid OAuth Client Id;
- `editSecret`: Only for Touristic objects edit, the corresponding secret;
- `exportDir`: `Default /tmp/exports/` The directory where we store and extract ZIP exports;
- `timeout`: `Default 0` Float describing the timeout of the request in seconds;
- `connectTimeout`: `Default 0` Float describing the number of seconds to wait while trying to connect to the server;
- `proxy`: `Default null` [String or array to specify](http://guzzle.readthedocs.org/en/latest/clients.html#proxy) an HTTP proxy (like `http://username:password@192.168.16.1:42`);
- `verify`: `Default true` [Boolean or string to describe](http://guzzle.readthedocs.org/en/latest/request-options.html#verify) the SSL certificate verification behavior of a request;
- `responseFields`: Allow to filter the fields returned globally for all object related queries ([documentation](http://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/filtrage-des-donnees));
- `locales`: Allow to filter the locales returned globally for all object related queries ([documentation](http://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/filtrage-des-langues));
- `count`: Allow to change the number of results globally for all object related queries;
- `ssoBaseUrl`: `Default https://base.apidae-tourisme.com` Not mandatory : Base URL for SSO authentication ([documentation](http://dev.apidae-tourisme.com/fr/documentation-technique/v2/oauth/single-sign-on)); Test environment : https://base.apidae-tourisme.cooking
- `ssoRedirectUrl`: The URL where SSO user will be sent back in your application;
- `ssoClientId`: The SSO OAuth client ID;
- `ssoSecret`: The SSO OAuth client secret.
