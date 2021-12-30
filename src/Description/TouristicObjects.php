<?php

namespace ApidaePHP\Description;

class TouristicObjects extends AbstractDescriptions
{
    /** @var array<mixed> $operations */
    public static array $operations = array(
        // @see http://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002objet-touristiqueget-by-id
        'getObjectById' => [
            'httpMethod' => 'GET',
            'uri' => '/api/v002/objet-touristique/get-by-id/{id}',
            'docUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002objet-touristiqueget-by-id',
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
        'objetTouristiqueGetById' => ['extends' => 'getObjectById'],
        'getObjectByIdentifier' => [
            'httpMethod' => 'GET',
            'uri' => '/api/v002/objet-touristique/get-by-identifier/{identifier}',
            'docUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002objet-touristiqueget-by-identifier',
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
        'objetTouristiqueGetByIdentifier' => ['extends' => 'getObjectByIdentifier']
    );
}
