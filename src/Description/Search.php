<?php

namespace ApidaePHP\Description;

class Search extends AbstractDescriptions
{
    /** @var array<mixed> $operations */
    public static array $operations = [
        'searchObject' => [
            'httpMethod' => 'POST',
            'uri' => '/api/v002/recherche/list-objets-touristiques',
            'documentationUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002recherchelist-objets-touristiques',
            'responseModel' => 'getResponse',
            'parameters' => [
                'query' => [
                    'type'      => 'string',
                    'location'  => 'formParam',
                    'required'  => true,
                    'filters' => [
                        [
                            'method' => '\ApidaePHP\Description\Search::encodeQuery',
                            'args' => ['@value', 'searchObject', 'apiObjetsTouristiquesRequete']
                        ]
                    ],
                ],
            ],
        ],
        'rechercheListObjetsTouristiques' => ['extends' => 'searchObject'],
        'searchObjectIdentifier' => [
            'extends' => 'searchObject',
            'uri' => '/api/v002/recherche/list-identifiants',
            'documentationUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002recherchelist-identifiants',
        ],
        'rechercheListIdentifiants' => ['extends' => 'searchObjectIdentifier']
    ];
}
