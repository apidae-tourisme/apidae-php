<?php

namespace ApidaePHP\Description;

class Agenda extends AbstractDescriptions
{
    /** @var array<mixed> $operations */
    public static array $operations = array(
        'searchAgenda' => [
            'httpMethod' => 'POST',
            'uri' => '/api/v002/agenda/simple/list-objets-touristiques',
            'documentationUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002agendasimplelist-objets-touristiques',
            'responseModel' => 'getResponse',
            'parameters' => [
                'query' => [
                    'type'      => 'string',
                    'location'  => 'formParam',
                    'required'  => true,
                    'filters' => [
                        [
                            'method' => '\ApidaePHP\Description\Agenda::encodeQuery',
                            'args' => ['@value', 'searchAgenda', 'apiObjetsTouristiquesRequete']
                        ]
                    ],
                ],
            ],
        ],
        'agendaSimpleListObjetsTouristiques' => ['extends' => 'searchAgenda'],
        'searchAgendaIdentifier' => [
            'extends' => 'searchAgenda',
            'uri' => '/api/v002/agenda/simple/list-identifiants',
            'documentationUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002agendasimplelist-identifiants'
        ],
        'agendaSimpleListIdentifiants' => ['extends' => 'searchAgendaIdentifier'],
        'searchDetailedAgenda' => [
            'extends' => 'searchAgenda',
            'uri' => '/api/v002/agenda/detaille/list-objets-touristiques',
            'documentationUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002agendadetaillelist-objets-touristiques'
        ],
        'agendaDetailleListObjetsTouristiques' => ['extends' => 'searchDetailedAgenda'],
        'searchDetailedAgendaIdentifier' => [
            'extends' => 'searchAgenda',
            'uri' => '/api/v002/agenda/detaille/list-identifiants',
            'documentationUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002agendadetaillelist-identifiants'
        ],
        'agendaDetailleListIdentifiants' => ['extends' => 'searchDetailedAgendaIdentifier'],
    );
}
