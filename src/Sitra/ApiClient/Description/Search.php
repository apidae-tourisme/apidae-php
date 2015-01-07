<?php

namespace Sitra\ApiClient\Description;

class Search
{
    public static $operations = array(
        // @see http://www.sitra-rhonealpes.com/wiki/index.php/API_V2_-_services_-_format_de_la_requete
        'searchObject' => [
            'httpMethod' => 'POST',
            'uri' => '/api/v002/recherche/list-objets-touristiques',
            'responseModel' => 'getResponse',
            'parameters' => [
                'query' => [
                    'type'      => 'string',
                    'location'  => 'postField',
                    'required'  => true,
                    'filters' => [
                        '\Sitra\ApiClient\Description\Search::encodeSearchQuery',
                    ],
                ]
            ],
        ],
        'searchObjectIdentifier' => [
            'httpMethod' => 'POST',
            'uri' => '/api/v002/recherche/list-identifiants',
            'responseModel' => 'getResponse',
            'parameters' => [
                'query' => [
                    'type'      => 'string',
                    'location'  => 'postField',
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
