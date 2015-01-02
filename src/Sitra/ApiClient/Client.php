<?php

namespace Sitra\ApiClient;

use GuzzleHttp\Client as BaseClient;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use Sitra\ApiClient\Description\OAuth;
use Sitra\ApiClient\Description\TouristicObjects;
use Sitra\ApiClient\Subscriber\AuthentificationSubscriber;

/**
 * Magic operations:
 *
 * @method array getObjectById() getObjectById(array $params)
 */
class Client extends GuzzleClient
{
    /**
     * @todo  expose options for the Guzzle client like timeout
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $client             = new BaseClient();

        $operations = array_merge(
            TouristicObjects::$operations,
            OAuth::$operations
        );

        $serviceConfig = [];
        $descriptionDefault = [
            'baseUrl' => 'http://api.sitra-tourisme.com/',
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

        $description = new Description(array_merge($descriptionDefault, $config));

        parent::__construct($client, $description, $serviceConfig);

        $this->getEmitter()->attach(
            new AuthentificationSubscriber($description, $config)
        );
    }
}
