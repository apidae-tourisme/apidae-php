<?php

namespace Sitra\ApiClient\Description;

class Agenda
{
    public static $operations = array(
        // @see http://www.sitra-rhonealpes.com/wiki/index.php/Sitra2_-_API_V2#Agenda
        'searchAgenda' => [
            'httpMethod' => 'POST',
            'uri' => '/api/v002/agenda/simple/list-objets-touristiques',
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
        'searchAgendaIdentifier' => [
            'httpMethod' => 'POST',
            'uri' => '/api/v002/agenda/simple/list-identifiants',
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
        'searchDetailedAgenda' => [
            'httpMethod' => 'POST',
            'uri' => '/api/v002/agenda/detaille/list-objets-touristiques',
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
        'searchDetailedAgendaIdentifier' => [
            'httpMethod' => 'POST',
            'uri' => '/api/v002/agenda/detaille/list-identifiants',
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
}
