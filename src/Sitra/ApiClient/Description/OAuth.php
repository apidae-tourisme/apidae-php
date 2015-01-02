<?php

namespace Sitra\ApiClient\Description;

class OAuth
{
    public static $operations = array(
        'getClientCredentialToken' => [
            'httpMethod' => 'GET',
            'uri' => '/oauth/token',
            'responseModel' => 'getResponse',
            'parameters' => [
                'grant_type' => [
                    'type' => 'string',
                    'location' => 'query',
                    'required' => true,
                    'static'   => true,
                    'default' => 'client_credentials'
                ]
            ]
        ]
        // @todo Complete with all operations following the example
    );
}
