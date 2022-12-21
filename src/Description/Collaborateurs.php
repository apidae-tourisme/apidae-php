<?php

namespace ApidaePHP\Description;

class Collaborateurs extends AbstractDescriptions
{
    /** @var array<mixed> $operations */
    public static array $operations = array(
        'postCollaborateurs' => [
            'httpMethod' => 'POST',
            'uri' => '/api/v002/collaborateurs/',
            'documentationUrl' => 'https://dev.apidae-tourisme.com/documentation-technique/v2/api-decriture/v002-collaborateurs/',
            'responseModel' => 'getResponse',
            'parameters' => [
                'query' => [
                    'type'      => 'string',
                    'location'  => 'formParam',
                    'required'  => true
                ],
            ],
        ],
        'getCollaborateurs' => [
            'httpMethod' => 'GET',
            'uri' => '/api/v002/collaborateurs/',
            'documentationUrl' => 'https://dev.apidae-tourisme.com/documentation-technique/v2/api-de-diffusion/liste-des-services/v002-collaborateurs/',
            'responseModel' => 'getResponse',
            'parameters' => [
                'query' => [
                    'type'      => 'string',
                    'location'  => 'formParam',
                    'required'  => true
                ],
            ],
        ]
    );
}
