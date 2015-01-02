<?php

namespace Sitra\ApiClient;

use GuzzleHttp\Client as BaseClient;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use Sitra\ApiClient\Description\TouristicObjects;

class Client extends GuzzleClient
{
    protected $apiKey;
    protected $projectId;

    public function __construct(array $config = [])
    {
        $this->apiKey       = isset($config['apiKey']) ? $config['apiKey'] : null;
        $this->projectId    = isset($config['projectId']) ? $config['projectId'] : null;
        $client             = new BaseClient();

        $operations = array_merge(TouristicObjects::$operations, []);

        $serviceConfig = [];
        $descriptionDefault = [
            'baseUrl' => 'http://api.sitra-tourisme.com/api/v002/',
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
    }

    public function __call($name, array $arguments)
    {
        $arguments = isset($arguments[0]) ? $arguments[0] : [];

        // If not defined in the service definition, they are not used
        $arguments = array_merge(["apiKey" => $this->apiKey, "projetId" => $this->projectId], $arguments);

        $command = $this->getCommand($name, $arguments);

        return $this->execute($command);
    }
}
