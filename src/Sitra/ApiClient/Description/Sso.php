<?php

namespace Sitra\ApiClient\Description;

class Sso
{
    public static $operations = array(
        // @see http://www.sitra-rhonealpes.com/wiki/index.php/Sitra_-_Authentification_OAuth#Single_Sign-On_.28SSO.29
        'getSsoToken' => [
            'httpMethod' => 'GET',
            'uri' => '/oauth/token',
            'responseModel' => 'getResponse',
            'parameters' => [
                'grant_type' => [
                    'type' => 'string',
                    'location' => 'query',
                    'required' => true,
                    'static' => true,
                    'default' => 'authorization_code',
                ],
                'code' => [
                    'type' => 'string',
                    'location' => 'query',
                    'required' => true,
                ],
                'redirect_uri' => [
                    'type' => 'string',
                    'location' => 'query',
                    'required' => true,
                ],
            ],
        ],
        'refreshSsoToken' => [
            'httpMethod' => 'GET',
            'uri' => '/oauth/token',
            'responseModel' => 'getResponse',
            'parameters' => [
                'grant_type' => [
                    'type' => 'string',
                    'location' => 'query',
                    'required' => true,
                    'static' => true,
                    'default' => 'refresh_token',
                ],
                'refresh_token' => [
                    'type' => 'string',
                    'location' => 'query',
                    'required' => true,
                ],
                'redirect_uri' => [
                    'type' => 'string',
                    'location' => 'query',
                    'required' => true,
                ],
            ],
        ],
    );
}
