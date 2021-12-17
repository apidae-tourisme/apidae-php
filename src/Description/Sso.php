<?php

namespace ApidaePHP\Description;

class Sso
{
    /** @var array<mixed> $operations */
    public static array $operations = array(
        'getSsoToken' => [
            'httpMethod' => 'GET',
            'uri' => '/oauth/token',
            'docUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/oauth/single-sign-on',
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
        'oauthToken' => ['extends' => 'getSsoToken'],
        'refreshSsoToken' => [
            'httpMethod' => 'GET',
            'uri' => '/oauth/token',
            'docUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/oauth/single-sign-on',
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
        ]
    );
}
