<?php

namespace Sitra\ApiClient\Description;

class TouristicObjects
{
    public static $operations = array(
        // @see http://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002objet-touristiqueget-by-id
        'getObjectById' => [
            'httpMethod' => 'GET',
            'uri' => '/api/v002/objet-touristique/get-by-id/{id}',
            'responseModel' => 'getResponse',
            'parameters' => [
                'id' => [
                    'type' => 'integer',
                    'location' => 'uri',
                    'required' => true,
                ],
                'responseFields' => [
                    'type' => 'string',
                    'location' => 'query',
                ],
                'locales' => [
                    'type' => 'string',
                    'location' => 'query',
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
        'getObjectByIdentifier' => [
            'httpMethod' => 'GET',
            'uri' => '/api/v002/objet-touristique/get-by-identifier/{identifier}',
            'responseModel' => 'getResponse',
            'parameters' => [
                'identifier' => [
                    'type' => 'string',
                    'location' => 'uri',
                    'required' => true,
                ],
                'responseFields' => [
                    'type' => 'string',
                    'location' => 'query',
                ],
                'locales' => [
                    'type' => 'string',
                    'location' => 'query',
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
    );
}
