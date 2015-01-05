<?php

namespace Sitra\ApiClient\Subscriber;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Command\Event\InitEvent;
use GuzzleHttp\Command\Event\PreparedEvent;
use GuzzleHttp\Command\Guzzle\DescriptionInterface;
use GuzzleHttp\Event\SubscriberInterface;

class AuthentificationSubscriber implements SubscriberInterface {

    private $description;
    private $config;
    private $client;

    public function __construct(DescriptionInterface $description, array $config, ClientInterface $client)
    {
        $this->description  = $description;
        $this->config       = $config;
        $this->client       = $client;
    }

    public function getEvents()
    {
        return [
            'init' => ['onInit', 1],
            'prepared' => ['onPrepare', 200]
        ];
    }

    /**
     * Automatically set apiKey & projetId query parameters when needed
     *
     * @param InitEvent $event
     */
    public function onInit(InitEvent $event)
    {
        $command = $event->getCommand();
        $operation = $this->description->getOperation($command->getName());

        if ($operation->hasParam('apiKey') && !isset($command['apiKey'])) {
            $command['apiKey'] = $this->config['apiKey'];
        }

        if ($operation->hasParam('projetId') && !isset($command['projetId'])) {
            $command['projetId'] = $this->config['projectId'];
        }
    }

    /**
     * Add OAuth token in header when needed
     *
     * @param PreparedEvent $event
     */
    public function onPrepare(PreparedEvent $event)
    {
        $command = $event->getCommand();
        $operation = $this->description->getOperation($command->getName());

        // If this operation require an OAuth scope
        if ($operation->getData('scope')) {
            $token = $this->getOAuthToken();

            $event->getRequest()->addHeader('Authorization', sprintf('Bearer %s', $token));
        }
    }

    /**
     * @todo Call the real service and cache the result for subsequent requests
     * @return string
     */
    protected function getOAuthToken()
    {
        return false;
        // @todo Wait for API fix (getting an error 500)

        $tokenResponse = $this->client->get('/oauth/token', [
            'auth' => [
                $this->config['OAuthClientId'],
                $this->config['OAuthSecret'],
            ],
            'query' => [
                'grant_type' => 'client_credentials'
            ]
        ]);
    }
}

