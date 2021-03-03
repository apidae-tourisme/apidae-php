<?php

    ini_set('display_errors',1) ;
    error_reporting(E_ALL) ;
    session_start() ;
    
    require __DIR__."/requires.inc.php" ;

    echo '<pre>' ;

    /**
     * This URL need to be registered in your SSO project on Apidae,
     * or you will have a 404 error,
     * Apidae refusing to redirect and give the code to this page.
     */ 
    $config['ssoRedirectUrl'] = 'http'.(($_SERVER['SERVER_PORT']=='80')?'':'s').'://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'] ;

    if ( isset($_GET['logout']) ) unset($_SESSION['ssoToken']) ;

    // Create the client
    $client = new \Sitra\ApiClient\Client([
        'ssoRedirectUrl' => $config['ssoRedirectUrl'],
        'ssoClientId'    => $config['ssoClientId'],
        'ssoSecret'      => $config['ssoSecret'],
        'debug'          => true,
        'ssoToken'       => @$_SESSION['ssoToken']
    ]);

    /**
     * This is the second step.
     * After user identify himself on Apidae, he's redirected here (to ssoRedirectUrl) with a GET['code']
     * This code 
     */
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

    try {
        // Now you can call SSO only methods:
        echo '<h1>getUserProfile</h1>' ;
        $profile = $client->getUserProfile();
        echo '<pre>'.print_r($profile,true ).'</pre>' ;
    } catch ( \Exception $e ) {
        echo '<pre>' ;
            echo $e->getMessage() ;
        echo '</pre>' ;
    }

    try {
        $id = 5679881 ;
        echo '<h1>getUserPermissionOnObject([id => '.$id.'])</h1>' ;
        $permissions = $client->getUserPermissionOnObject(['id' => $id]) ;  
        echo $permissions['response']->getContents() ;
    } catch ( \Exception $e ) {
        echo '<pre>' ;
            echo $e->getMessage() ;
        echo '</pre>' ;
    }