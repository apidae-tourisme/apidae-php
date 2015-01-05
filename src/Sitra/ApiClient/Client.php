<?php

namespace Sitra\ApiClient;

use GuzzleHttp\Client as BaseClient;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use Sitra\ApiClient\Description\Metadata;
use Sitra\ApiClient\Description\TouristicObjects;
use Sitra\ApiClient\Subscriber\AuthenticationSubscriber;

/**
 * Magic operations:
 *
 * @todo   complete this list
 * @method array getObjectById() getObjectById(array $params)
 *
 * @method array getMetadata() getMetadata(array $params)
 * @method array deleteMetadata() deleteMetadata(array $params)
 * @method array putMetadata() putMetadata(array $params)
 */
class Client extends GuzzleClient
{
    protected $config = [
        'baseUrl'       => 'http://api.sitra-tourisme.com/',
        'apiKey'        => null,
        'projectId'     => null,
        'OAuthClientId' => null,
        'OAuthSecret'   => null,
    ];

    /**
     * @todo  expose options for the Guzzle client like timeout
     * @todo  validate $config params
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = array_merge($this->config, $config);

        $client = new BaseClient(['base_url' => $this->config['baseUrl']]);

        $operations = array_merge(
            TouristicObjects::$operations,
            Metadata::$operations
        );

        $descriptionData = [
            'baseUrl' => $this->config['baseUrl'],
            'operations' => $operations,
            'models' => [
                'getResponse' => [
                    'type' => 'object',
                    'additionalProperties' => [
                        'location' => 'json',
                    ],
                ],
            ],
        ];

        $description = new Description($descriptionData);

        parent::__construct($client, $description, []);

        $this->getEmitter()->attach(
            new AuthenticationSubscriber($description, $this->config, $this->getHttpClient())
        );
    }
}
