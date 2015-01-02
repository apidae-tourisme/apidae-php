<?php

namespace Sitra\ApiClient\Description;

class TouristicObjects
{
    public static $operations = array(
        'getObjectById' => [
            'httpMethod' => 'GET',
            'uri' => 'objet-touristique/get-by-id/{id}',
            'responseModel' => 'getResponse',
            'parameters' => [
                'id' => [
                    'type' => 'integer',
                    'location' => 'uri',
                    'required' => true
                ],
                'responseFields' => [
                    'type' => 'string',
                    'location' => 'query'
                ],
                'locales' => [
                    'type' => 'string',
                    'location' => 'query'
                ],
                'apiKey' => [
                    'type' => 'string',
                    'location' => 'query',
                    'required' => true
                ],
                'projetId' => [
                    'type' => 'string',
                    'location' => 'query',
                    'required' => true
                ]
            ]
        ]
        // @todo Complete with all operations following the example
    );
}
