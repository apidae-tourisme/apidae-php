<?php

namespace Sitra\ApiClient;

use GuzzleHttp\Client as BaseClient;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use Sitra\ApiClient\Description\Metadata;
use Sitra\ApiClient\Description\OAuth;
use Sitra\ApiClient\Description\TouristicObjects;
use Sitra\ApiClient\Subscriber\AuthentificationSubscriber;

/**
 * Magic operations:
 *
 * @todo   complete this list
 * @method array getObjectById() getObjectById(array $params)
 * @method array getMetadata() getMetadata(array $params)
 */
class Client extends GuzzleClient
{
    /**
     * @todo  expose options for the Guzzle client like timeout
     * @todo  validate $config params
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $baseUrl = $config['baseUrl'] ? $config['baseUrl'] : 'http://api.sitra-tourisme.com/';
        $client = new BaseClient(['base_url' => $baseUrl]);

        $operations = array_merge(
            TouristicObjects::$operations,
            Metadata::$operations
        );

        $serviceConfig = [];
        $descriptionData = [
            'baseUrl' => $baseUrl,
            'operations' => $operations,
            'models' => [
                'getResponse' => [
                    'type' => 'object',
                    'additionalProperties' => [
                        'location' => 'json'
                    ]
                ]
            ]
        ];

        $description = new Description($descriptionData);

        parent::__construct($client, $description, $serviceConfig);

        $this->getEmitter()->attach(
            new AuthentificationSubscriber($description, $config, $this->getHttpClient())
        );
    }
}
