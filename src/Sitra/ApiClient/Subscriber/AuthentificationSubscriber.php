<?php

namespace Sitra\ApiClient\Subscriber;

use GuzzleHttp\Command\Event\InitEvent;
use GuzzleHttp\Command\Event\PreparedEvent;
use GuzzleHttp\Command\Guzzle\DescriptionInterface;
use GuzzleHttp\Event\SubscriberInterface;

class AuthentificationSubscriber implements SubscriberInterface {

    private $description;
    private $config;
    protected $apiKey;
    protected $projectId;

    public function __construct(DescriptionInterface $description, $config)
    {
        $this->apiKey       = isset($config['apiKey']) ? $config['apiKey'] : null;
        $this->projectId    = isset($config['projectId']) ? $config['projectId'] : null;

        $this->description = $description;
        $this->config = $config;
    }

    public function getEvents()
    {
        return [
            'init' => ['onInit', 1],
            'prepared' => ['onPrepare', 200]
        ];
    }

    /**
     * Automatically set apiKey & projetId query parameters if needed
     *
     * @param InitEvent $event
     */
    public function onInit(InitEvent $event)
    {
        $command = $event->getCommand();
        $operation = $this->description->getOperation($command->getName());

        if ($operation->hasParam('apiKey') && !isset($command['apiKey'])) {
            $command['apiKey'] = $this->apiKey;
        }

        if ($operation->hasParam('projetId') && !isset($command['projetId'])) {
            $command['projetId'] = $this->projectId;
        }
    }

    /**
     * @todo Get OAuth access token for OAuth protected queries
     * @param PreparedEvent $event
     */
    public function onPrepare(PreparedEvent $event)
    {
        return;

        $command = $event->getCommand();
        $operation = $this->description->getOperation($command->getName());
    }
}

