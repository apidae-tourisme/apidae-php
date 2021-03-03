<?php

namespace Sitra\ApiClient\Description;

class Member
{
    public static $operations = array(
        
        // @see http://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002membreget-by-id-2
        // @see http://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002membreget-membres

        'getMemberById' => [
            'httpMethod' => 'GET',
            'uri' => '/api/v002/membre/get-by-id/{id}',
            'responseModel' => 'getResponse',
            'parameters' => [
                'id' => [
                    'type' => 'integer',
                    'location' => 'uri',
                    'required' => true,
                ],
                'apiKey' => [
                    'type' => 'string',
                    'location' => 'query',
                    'required' => true,
                ],
                'projetId' => [
                    'type' => 'string',
                    'location' => 'query',
                    'required' => true,
                ],
            ],
        ],
        'getMembers' => [
            'httpMethod' => 'POST',
            'uri' => '/api/v002/membre/get-membres',
            'responseModel' => 'getResponse',
            'parameters' => [
                'query' => [
                    'type'      => 'string',
                    'location'  => 'formParam',
                    'required'  => true,
                    'filters' => [
                        '\Sitra\ApiClient\Description\Search::encodeSearchQuery',
                    ],
                ],
            ],
        ],
        'getUserById' => [
            'httpMethod' => 'GET',
            'uri' => '/api/v002/utilisateur/get-by-id/{id}',
            'responseModel' => 'getResponse',
            'parameters' => [
                'id' => [
                    'type' => 'integer',
                    'location' => 'uri',
                    'required' => true,
                ],
                'apiKey' => [
                    'type' => 'string',
                    'location' => 'query',
                    'required' => true,
                ],
                'projetId' => [
                    'type' => 'string',
                    'location' => 'query',
                    'required' => true,
                ],
            ],
        ],
        'getUserByMail' => [
            'httpMethod' => 'GET',
            'uri' => '/api/v002/utilisateur/get-by-mail/{eMail}',
            'responseModel' => 'getResponse',
            'parameters' => [
                'eMail' => [
                    'type' => 'string',
                    'location' => 'uri',
                    'required' => true,
                ],
                'apiKey' => [
                    'type' => 'string',
                    'location' => 'query',
                    'required' => true,
                ],
                'projetId' => [
                    'type' => 'string',
                    'location' => 'query',
                    'required' => true,
                ],
            ],
        ],
        'getUsersByMember' => [
            'httpMethod' => 'GET',
            'uri' => '/api/v002/utilisateur/get-by-membre/{membre_id}',
            'responseModel' => 'getResponse',
            'parameters' => [
                'membre_id' => [
                    'type' => 'integer',
                    'location' => 'uri',
                    'required' => true,
                ],
                'apiKey' => [
                    'type' => 'string',
                    'location' => 'query',
                    'required' => true,
                ],
                'projetId' => [
                    'type' => 'string',
                    'location' => 'query',
                    'required' => true,
                ],
            ],
        ],/*
        'getAllUsers' => [
            'httpMethod' => 'GET',
            'uri' => '/api/v002/utilisateur/get-all-utilisateurs',
            'responseModel' => 'getResponse',
            'parameters' => [
                'apiKey' => [
                    'type' => 'string',
                    'location' => 'query',
                    'required' => true,
                ],
                'projetId' => [
                    'type' => 'string',
                    'location' => 'query',
                    'required' => true,
                ],
            ],
        ]*/
    );
}
