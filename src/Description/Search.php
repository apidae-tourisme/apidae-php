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

    public static $queryParams = [
        'apiKey' => [],
        'projetId' => [],
        'identifiants' => [],
        'identifiers' => [],
        'listeEnregistreeId' => [],
        'selectionIds' => [],
        'center' => [],
        'radius' => [],
        'communeCodesInsee' => [],
        'territoireIds' => [],
        'searchQuery' => [],
        'searchFields' => [],
        'criteresQuery' => [],
        'dateDebut' => [],
        'dateFin' => [],
        'first' => [],
        'count' => [],
        'order' => [],
        'asc' => [],
        'randomSeed' => [],
        'locales' => [],
        'responseFields' => [],
        'membreProprietaireIds' => []
    ];

    /** @param array<mixed> $query */
    public static function encodeSearchQuery(array|string $query): string
    {
        if (!is_array($query)) {
            $query = json_decode($query, true);
            if (json_last_error() !== JSON_ERROR_NONE)
                throw new \Exception('\'query\' parameter is not a valid json string : ' . $query);
        }

        $paramsKeys = array_keys(self::$queryParams);

        foreach ($query as $param => $values) {
            if (!in_array($param, $paramsKeys)) {
                throw new \Exception('Parameter ' . $param . ' is not a valid query parameter (not in ' . implode(', ', $paramsKeys) . ')');
            }
        }

        return json_encode($query);
    }
}
