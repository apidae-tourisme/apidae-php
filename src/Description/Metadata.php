<?php

namespace ApidaePHP\Description;

use GuzzleHttp\Query;
use ApidaePHP\Exception\InvalidMetadataFormatException;
use ApidaePHP\Client as ClientApi;

class Metadata extends AbstractDescriptions
{
    const ALLOWED_KEY_REGEX = '/^(membre(s|$)(\.membre_\d+)?)$|^(projet(s|$)(\.projet_\d+)?)$|^general$|^node$/';

    /** @var array<mixed> $operations */
    public static array $operations = array(
        // @see http://dev.apidae-tourisme.com/fr/documentation-technique/v2/metadonnees
        'getMetadata' => [
            'httpMethod' => 'GET',
            'uri' => '/api/v002/metadata/{referenceId}/{nodeId}{/targetType}{/targetId}',
            'documentationUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/metadonnees/web-service',
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
                    'enum' => ['general', 'membre', 'projet']
                ],
                'targetId' => [
                    'type' => 'integer',
                    'location' => 'uri',
                    'required' => false,
                ],
            ],
            'data' => [
                'scope' => ClientApi::META_SCOPE,
            ],
        ],
        'deleteMetadata' => [
            'httpMethod' => 'DELETE',
            'uri' => '/api/v002/metadata/{referenceId}/{nodeId}{/targetType}{/targetId}',
            'documentationUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/metadonnees/web-service',
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
                    'enum' => ['general', 'membre', 'projet']
                ],
                'targetId' => [
                    'type' => 'integer',
                    'location' => 'uri',
                    'required' => false,
                ],
            ],
            'data' => [
                'scope' => ClientApi::META_SCOPE,
            ],
        ],
        'putMetadata' => [
            'httpMethod' => 'PUT',
            'uri' => '/api/v002/metadata/{referenceId}/{nodeId}',
            'documentationUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/metadonnees/web-service',
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
                    'examples' => ['tripadvisor', 'opensystem', '...']
                ],
                /*
                'metadata' => [
                    'required' => true,
                    'location' => 'body',
                    'filters' => [
                        '\ApidaePHP\Description\Metadata::validateMetadata',
                    ],
                ],
                */
                'general' => [
                    'type' => 'string',
                    'location' => 'body',
                    'filters' => [
                        '\ApidaePHP\Description\Metadata::validateMetadata',
                    ],
                ],
                'membres' => [
                    'type' => 'string',
                    'location' => 'body',
                    'filters' => [
                        '\ApidaePHP\Description\Metadata::validateMetadata',
                    ],
                ],
                'projets' => [
                    'type' => 'string',
                    'location' => 'body',
                    'filters' => [
                        '\ApidaePHP\Description\Metadata::validateMetadata',
                    ],
                ],
                'node' => [
                    'type' => 'string',
                    'location' => 'body',
                    'filters' => [
                        '\ApidaePHP\Description\Metadata::validateMetadata',
                    ],
                ],
            ],
            'data' => [
                'scope' => ClientApi::META_SCOPE,
            ],
        ],
    );

    /**
     * @param array<array<mixed>> $metadata
     * @return array<array<mixed>>
     */
    public static function validateMetadata(null|array $metadata): array
    {
        if (empty($metadata)) {
            throw new InvalidMetadataFormatException();
        }

        if (is_array($metadata)) {
            foreach ($metadata as $name => $data) {
                if (preg_match(self::ALLOWED_KEY_REGEX, $name) === 0) {
                    throw new InvalidMetadataFormatException();
                }

                if (is_array($data)) {
                    $metadata[$name] = json_encode($data);
                } elseif (empty($data)) {
                    throw new InvalidMetadataFormatException();
                }
            }
        }

        return $metadata;
    }
}
