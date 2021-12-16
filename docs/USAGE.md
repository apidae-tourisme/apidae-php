# USage

## Creating a Client

You need to create a `Client` instance:

```php
$client = new \ApidaePHP\Client([
    'apiKey'           => 'XXX',
    'projetId'        => 672,
    'OAuthClientId'    => 'XXX',
    'OAuthSecret'      => 'XXX',
    'exportDir'        => '/tmp/exports',

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
    'ssoRedirectUrl'   => 'http://localhost/',
    'ssoClientId'      => 'XXX',
    'ssoSecret'        => 'XXX',
]);

// You can also only use the mandatory parameters (all options have sensible defaults).
$client = new \ApidaePHP\Client([
    'apiKey'           => 'XXX',
    'projetId'        => 672,
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

## Options

- `apiKey`: Project API Key;
- `projetId`: Corresponding projetId;
- `baseUri`: Not mandatory, useful if you want to hit test environment i.e. https://api.apidae-tourisme.cooking/;
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
- `ssoBaseUrl`: Not mandatory : Base URL for SSO authentication ([documentation](http://dev.apidae-tourisme.com/fr/documentation-technique/v2/oauth/single-sign-on)); Default is https://base.apidae-tourisme.com (production). Test environment : https://base.apidae-tourisme.cooking
- `ssoRedirectUrl`: The URL where SSO user will be sent back in your application;
- `ssoClientId`: The SSO OAuth client ID;
- `ssoSecret`: The SSO OAuth client secret.
