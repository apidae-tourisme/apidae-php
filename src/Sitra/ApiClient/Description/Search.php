<?php

namespace Sitra\ApiClient\Description;

class Search
{
    public static $operations = array(
        // @see http://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/format-des-recherches
        'searchObject' => [
            'httpMethod' => 'POST',
            'uri' => '/api/v002/recherche/list-objets-touristiques',
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
        'searchObjectIdentifier' => [
            'httpMethod' => 'POST',
            'uri' => '/api/v002/recherche/list-identifiants',
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
    );

    public static function encodeSearchQuery($query)
    {
        if (is_array($query)) {
            return json_encode($query);
        }

        return $query;
    }
}
