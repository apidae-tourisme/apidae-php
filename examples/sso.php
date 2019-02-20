<?php

ini_set('display_errors',1) ;
error_reporting(E_ALL) ;

/**
 * @TODO
 * au 20/02/2019, sur la 1.0.5, l'auth SSO ne fonctionne pas.
 * Se référer au ticket https://github.com/apidae-tourisme/sitra-api-php/issues/12
 */

// Include Composer autoload
require __DIR__."/../../../autoload.php";
require __DIR__."/../config.inc.php";

// Create the client
$client = new \Sitra\ApiClient\Client([
    'ssoRedirectUrl' => $config['ssoRedirectUrl'],
    'ssoClientId'    => $config['ssoClientId'],
    'ssoSecret'      => $config['ssoSecret'],
]);

$ssourl = $client->getSsoUrl() ;

// Display SSO url to the client (or redirect to it):
?>

<a href="<?php echo $ssourl ?>">Ask for auth code</a>

<?php

try {
    if (isset($_GET['code']) && !empty($_GET['code'])) {
        // The redirect URL get a "code", we use it to ask for a token
        $token = $client->getSsoToken(['code' => $_GET['code'], 'redirect_uri' => $config['ssoRedirectUrl']]);

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
