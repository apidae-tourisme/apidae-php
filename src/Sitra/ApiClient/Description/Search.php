<?php

namespace Sitra\ApiClient\Description;

class Search
{
    public static $operations = array(
        'searchObject' => [
            'httpMethod' => 'GET',
            'uri' => '/api/v002/recherche/list-objets-touristiques',
            'responseModel' => 'getResponse',
            'parameters' => [
                'query' => [
                    'type'      => 'string',
                    'location'  => 'query',
                    'required'  => true,
                    'filters' => [
                        '\Sitra\ApiClient\Description\Search::encodeSearchQuery',
                    ],
                ]
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
