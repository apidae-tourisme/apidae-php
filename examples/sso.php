<?php

    ini_set('display_errors',1) ;
    error_reporting(E_ALL) ;
    session_start() ;
    
    require __DIR__."/requires.inc.php" ;

    echo '<pre>' ;

    print_r($_SESSION) ;

    if ( isset($_GET['logout']) ) unset($_SESSION['ssoToken']) ;

    // Create the client
    $client = new \Sitra\ApiClient\Client([
        'ssoRedirectUrl' => $config['ssoRedirectUrl'],
        'ssoClientId'    => $config['ssoClientId'],
        'ssoSecret'      => $config['ssoSecret'],
        'debug'          => true,
        'ssoToken'       => @$_SESSION['ssoToken']
    ]);

    if (isset($_GET['code']) && !empty($_GET['code']) && ! isset($_SESSION['ssoToken'])) {
        try {
            // The redirect URL get a "code", we use it to ask for a token
            $token = $client->getSsoToken(['code' => $_GET['code'], 'redirect_uri' => $config['ssoRedirectUrl']]);
            // Store the new token in the client, will be used automatically!
            $client->setAccessToken($token['scope'], $token['access_token']);
            $_SESSION['ssoToken'] = Array(
                'access_token' => $token['access_token'],
                'refresh_token' => $token['refresh_token']
            ) ;
        } catch (\Sitra\Exception\SitraException $e) {
            echo $e->getMessage();
            echo "\n";
            echo $e->getPrevious()->getMessage();
        }
    }

    if ( ! isset($_SESSION['ssoToken']) )
    {

        $ssourl = $client->getSsoUrl() ;
        echo '<a href="'.$ssourl.'">Ask for auth code</a><br />' ;
        die('Not authentificated') ;
    }

    echo '<a href="?logout">Logout</a>' ;

    echo '<hr />' ;

    print_r($client->config('accessTokens')) ;

    try {
        // Now you can call SSO only methods:
        echo '<h1>getUserProfile</h1>' ;
        $profile = $client->getUserProfile();
        var_dump($profile);
    } catch ( \Exception $e ) {
        echo '<pre>' ;
            echo $e->getMessage() ;
        echo '</pre>' ;
    }

    try {
        $id = 5679881 ;
        echo '<h1>getUserPermissionOnObject([id => '.$id.'])</h1>' ;
        $permissions = $client->getUserPermissionOnObject(['id' => $id]);
        var_dump($permissions);
    } catch ( \Exception $e ) {
        echo '<pre>' ;
            echo $e->getMessage() ;
        echo '</pre>' ;
    }