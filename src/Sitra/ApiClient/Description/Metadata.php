<?php

namespace Sitra\ApiClient\Description;

class Metadata
{
    public static $operations = array(
        // @see http://www.sitra-rhonealpes.com/wiki/index.php/API_-_services_-_v002/metadata/
        'getMetadata' => [
            'httpMethod' => 'GET',
            'uri' => '/api/v002/metadata/{referenceId}/{nodeId}{/targetType}{/targetId}',
            'responseModel' => 'getResponse',
            'parameters' => [
                'referenceId' => [
                    'type' => 'integer',
                    'location' => 'uri',
                    'required' => true
                ],
                'nodeId' => [
                    'type' => 'string',
                    'location' => 'uri',
                    'required' => true
                ],
                'targetType' => [
                    'type' => 'string',
                    'location' => 'uri',
                    'required' => false
                ],
                'targetId' => [
                    'type' => 'integer',
                    'location' => 'uri',
                    'required' => false
                ],
            ],
            // This method require an OAuth scope
            'data' => [
                'scope' => 'api_metadonnees'
            ]
        ]
        // @todo Complete with all operations following the example
    );
}
