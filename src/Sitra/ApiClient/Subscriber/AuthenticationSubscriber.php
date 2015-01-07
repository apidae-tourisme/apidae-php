<?php

namespace Sitra\ApiClient\Subscriber;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Command\Event\InitEvent;
use GuzzleHttp\Command\Event\PreparedEvent;
use GuzzleHttp\Command\Guzzle\DescriptionInterface;
use GuzzleHttp\Event\SubscriberInterface;
use GuzzleHttp\Utils;

class AuthenticationSubscriber implements SubscriberInterface
{
    private $description;
    private $config;
    private $client;

    // @todo Invalidate in case of expiration
    private $accessToken;

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

        // Search operations use the authentication inside a query string JSON!
        if (in_array($operation->getName(), [
            'searchObject',
            'searchObjectIdentifier',
            'searchAgenda',
            'searchAgendaIdentifier',
            'searchDetailedAgendaIdentifier',
            'searchDetailedAgenda',
        ])) {
            $data = is_array($command['query']) ? $command['query'] : Utils::jsonDecode($command['query'], true);

            if (!isset($data['apiKey']) && !isset($data['projetId'])) {
                $data['apiKey'] = $this->config['apiKey'];
                $data['projetId'] = $this->config['projectId'];

                $command['query'] = json_encode($data);
            }
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
     * @return string
     */
    protected function getOAuthToken()
    {
        if ($this->accessToken) {
            return $this->accessToken;
        }

        $tokenResponse = $this->client->get('/oauth/token', [
            'auth' => [
                $this->config['OAuthClientId'],
                $this->config['OAuthSecret'],
            ],
            'query' => [
                'grant_type' => 'client_credentials',
            ],
            'headers' => [
                'accept' => 'application/json',
            ],
        ])->json();

        $this->accessToken = $tokenResponse['access_token'];

        return $this->accessToken;
    }
}
