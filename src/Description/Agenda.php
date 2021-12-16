<?php

namespace ApidaePHP\Description;

class Agenda
{
    public static $operations = array(
        // @see http://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/format-des-recherches
        // @see http://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/formats-de-reponse
        'searchAgenda' => [
            'httpMethod' => 'POST',
            'uri' => '/api/v002/agenda/simple/list-objets-touristiques',
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
        'agendaSimpleListObjetsTouristiques' => ['extends' => 'searchAgenda'],
        'searchAgendaIdentifier' => [
            'extends' => 'searchAgenda',
            'uri' => '/api/v002/agenda/simple/list-identifiants'
        ],
        'agendaSimpleListIdentifiants' => ['extends' => 'searchAgendaIdentifier'],
        'searchDetailedAgenda' => [
            'extends' => 'searchAgenda',
            'uri' => '/api/v002/agenda/detaille/list-objets-touristiques'
        ],
        'agendaDetailleListObjetsTouristiques' => ['extends' => 'searchDetailedAgenda'],
        'searchDetailedAgendaIdentifier' => [
            'extends' => 'searchAgenda',
            'uri' => '/api/v002/agenda/detaille/list-identifiants'
        ],
        'agendaDetailleListIdentifiants' => ['extends' => 'searchDetailedAgendaIdentifier'],
    );
}
