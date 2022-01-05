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
            'documentationUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002objet-touristiqueget-by-id',
            'summary' => 'get a touristic object by id',
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
                    'description' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/filtrage-des-donnees',
                    'default' => 'id,identifier,nom,informations.moyensCommunication,presentation.descriptifCourt,localisation.adresse,localisation.geolocalisation,illustrations'
                ],
                'locales' => [
                    'type' => 'string',
                    'location' => 'query',
                    'description' => 'Languages, separated with a comma : fr,en',
                    'examples' => ['fr', 'en', 'de', 'nl', 'it', 'es', 'ru', 'zh', 'pt-br', 'ja'],
                    'default' => 'fr'
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
            'documentationUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002objet-touristiqueget-by-identifier',
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
                    'default' => 'id,identifier,nom,informations.moyensCommunication,presentation.descriptifCourt,localisation.adresse,localisation.geolocalisation,illustrations'
                ],
                'locales' => [
                    'type' => 'string',
                    'location' => 'query',
                    'description' => 'Languages, separated with a comma : fr,en',
                    'examples' => ['fr', 'en', 'de', 'nl', 'it', 'es', 'ru', 'zh', 'pt-br', 'ja'],
                    'default' => 'fr'
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
