

### Using the SSO

[Full documentation](http://dev.apidae-tourisme.com/fr/documentation-technique/v2/oauth)

You must configure your client with the SSO options ('ssoRedirectUrl', 'ssoClientId' and 'ssoSecret' at least), 
then forward your user to the Apidae authorization URL. The user can then give your application the permission 
to access his data and will be redirected on your application with a code. This code is used to get an Access Token.

```php
$client = new \ApidaePHP\Client([
    'ssoRedirectUrl' => 'http://example.com/...',
    'ssoClientId'    => 'XXX',
    'ssoSecret'      => 'XXX',
]);

<a href="<?php echo $client->getSsoUrl() ?>">Ask for auth code</a>
```

Your redirect page must listen for a "code" GET parameter:

```php
if (isset($_GET['code']) && !empty($_GET['code'])) {
    // The redirect URL get a "code", we use it to ask for a token
    $token = $client->getSsoToken(['code' => $_GET['code'], 'redirect_uri' => 'http://example.com/...']);

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