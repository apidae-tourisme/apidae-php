<?php

namespace Sitra\ApiClient\Description;

use GuzzleHttp\Query;
use Sitra\ApiClient\Exception\InvalidMetadataFormatException;

class Metadata
{
    const ALLOWED_KEY_REGEX = '/membre[s|_\d+]?|projet[s|_\d+]?|general/';

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
                    'required' => true,
                ],
                'nodeId' => [
                    'type' => 'string',
                    'location' => 'uri',
                    'required' => true,
                ],
                'targetType' => [
                    'type' => 'string',
                    'location' => 'uri',
                    'required' => false,
                ],
                'targetId' => [
                    'type' => 'integer',
                    'location' => 'uri',
                    'required' => false,
                ],
            ],
            'data' => [
                'scope' => 'api_metadonnees',
            ],
        ],
        'deleteMetadata' => [
            'httpMethod' => 'DELETE',
            'uri' => '/api/v002/metadata/{referenceId}/{nodeId}{/targetType}{/targetId}',
            'responseModel' => 'getResponse',
            'parameters' => [
                'referenceId' => [
                    'type' => 'integer',
                    'location' => 'uri',
                    'required' => true,
                ],
                'nodeId' => [
                    'type' => 'string',
                    'location' => 'uri',
                    'required' => true,
                ],
                'targetType' => [
                    'type' => 'string',
                    'location' => 'uri',
                    'required' => false,
                ],
                'targetId' => [
                    'type' => 'integer',
                    'location' => 'uri',
                    'required' => false,
                ],
            ],
            'data' => [
                'scope' => 'api_metadonnees',
            ],
        ],
        'putMetadata' => [
            'httpMethod' => 'PUT',
            'uri' => '/api/v002/metadata/{referenceId}/{nodeId}{/targetType}{/targetId}',
            'responseModel' => 'getResponse',
            'parameters' => [
                'referenceId' => [
                    'type' => 'integer',
                    'location' => 'uri',
                    'required' => true,
                ],
                'nodeId' => [
                    'type' => 'string',
                    'location' => 'uri',
                    'required' => true,
                ],
                'metadata' => [
                    'required' => true,
                    'location' => 'body',
                    'filters' => [
                        '\Sitra\ApiClient\Description\Metadata::validateMetadata',
                    ],
                ],
            ],
            'data' => [
                'scope' => 'api_metadonnees',
            ],
        ],
    );

    public static function validateMetadata($metadata)
    {
        if (empty($metadata)) {
            throw new InvalidMetadataFormatException();
        }

        if (is_array($metadata)) {
            foreach ($metadata as $name => $data) {
                if (preg_match(self::ALLOWED_KEY_REGEX, $name) === 0) {
                    throw new InvalidMetadataFormatException();
                }
            }
        }

        // Force "form style" format
        return new Query($metadata);

        // @todo Encode json if value is array
        // @todo throw error if no value
        // @todo check array keys if we can
    }
}
