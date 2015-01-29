<?php

// Include Composer autoload
include __DIR__."/../vendor/autoload.php";

// Create the client
$client = new \Sitra\ApiClient\Client([
    'ssoRedirectUrl' => 'http://example.com/TODO',
    'ssoClientId'    => 'XXX',
    'ssoSecret'      => 'XXX',
]);

// Display SSO url to the client (or redirect to it):
?>

<a href="<?php echo $client->getSsoUrl() ?>">Ask for auth code</a>

<?php

try {
    if (isset($_GET['code']) && !empty($_GET['code'])) {
        // The redirect URL get a "code", we use it to ask for a token
        $token = $client->getSsoToken(['code' => $_GET['code'], 'redirect_uri' => 'http://example.com/TODO']);

        // Store the new token in the client, will be used automatically!
        $client->setAccessToken($token['scope'], $token['access_token']);

        // Now you can call SSO only methods:
        $profile = $client->getUserProfile();
        var_dump($profile);

        $permissions = $client->getUserPermissionOnObject(['id' => 123457]);
        var_dump($permissions);
    }
} catch (\Sitra\ApiClient\Exception\SitraException $e) {
    echo $e->getMessage();
    echo "\n";
    echo $e->getPrevious()->getMessage();
}
