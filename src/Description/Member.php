<?php

namespace ApidaePHP\Description;

class Member extends AbstractDescriptions
{
    /** @var array<mixed> $operations */
    public static array $operations = array(

        // @see http://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002membreget-by-id-2
        // @see http://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002membreget-membres

        'getMemberById' => [
            'httpMethod' => 'GET',
            'uri' => '/api/v002/membre/get-by-id/{id}',
            'documentationUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002membreget-by-id-2',
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
        'membreGetById' => ['extends' => 'getMemberById'],

        'getMembers' => [
            'httpMethod' => 'POST',
            'uri' => '/api/v002/membre/get-membres',
            'documentationUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002membreget-membres',
            'responseModel' => 'getResponse',
            'parameters' => [
                'query' => [
                    'type'      => 'string',
                    'location'  => 'formParam',
                    'required'  => true,
                    'filters' => [
                        [
                            'method' => '\ApidaePHP\Description\Member::encodeQuery',
                            'args' => ['@value', 'getMembers']
                        ]
                    ],
                ],
            ],
        ],
        'membreGetMembres' => ['extends' => 'getMembers'],

        'getUserById' => [
            'httpMethod' => 'GET',
            'uri' => '/api/v002/utilisateur/get-by-id/{id}',
            'documentationUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002utilisateurget-by-id',
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
        'utilisateurGetById' => ['extends' => 'getUserById'],

        'getUserByMail' => [
            'httpMethod' => 'GET',
            'uri' => '/api/v002/utilisateur/get-by-mail/{eMail}',
            'documentationUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002utilisateurget-by-mail',
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
        'utilisateurGetByMail' => ['extends' => 'getUserByMail'],

        'getUsersByMember' => [
            'httpMethod' => 'GET',
            'uri' => '/api/v002/utilisateur/get-by-membre/{membre_id}',
            'documentationUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002utilisateurget-by-membre',
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
        ],
        'utilisateurGetByMembre' => ['extends' => 'getUsersByMember'],
        /*
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
