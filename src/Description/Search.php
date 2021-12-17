<?php

namespace ApidaePHP\Description;

class Search
{
    /** @var array<mixed> $operations */
    public static array $operations = [
        'searchObject' => [
            'httpMethod' => 'POST',
            'uri' => '/api/v002/recherche/list-objets-touristiques',
            'docUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002recherchelist-objets-touristiques',
            'responseModel' => 'getResponse',
            'parameters' => [
                'query' => [
                    'type'      => 'string',
                    'location'  => 'formParam',
                    'required'  => true,
                    'filters' => [
                        '\ApidaePHP\Description\Search::encodeSearchQuery',
                    ],
                ],
            ],
        ],
        'rechercheListObjetsTouristiques' => ['extends' => 'searchObject'],
        'searchObjectIdentifier' => [
            'extends' => 'searchObject',
            'uri' => '/api/v002/recherche/list-identifiants',
            'docUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002recherchelist-identifiants',
        ],
        'rechercheListIdentifiants' => ['extends' => 'searchObjectIdentifier']
    ];

    /** @param array<mixed> $query */
    public static function encodeSearchQuery(array|string $query): string
    {
        if (is_array($query)) {
            return json_encode($query);
        }

        return $query;
    }
}
