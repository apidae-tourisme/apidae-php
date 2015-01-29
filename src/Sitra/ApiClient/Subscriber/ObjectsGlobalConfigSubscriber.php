<?php

namespace Sitra\ApiClient\Subscriber;

use GuzzleHttp\Command\Event\InitEvent;
use GuzzleHttp\Command\Guzzle\DescriptionInterface;
use GuzzleHttp\Event\SubscriberInterface;
use GuzzleHttp\Utils;

class ObjectsGlobalConfigSubscriber implements SubscriberInterface
{
    private $description;
    private $config;

    public function __construct(DescriptionInterface $description, $config)
    {
        $this->description  = $description;
        $this->config       = $config;
    }

    public function getEvents()
    {
        return [
            'init' => ['onInit', 5],
        ];
    }

    /**
     * Automatically set global configuration if provided
     *
     * @param InitEvent $event
     */
    public function onInit(InitEvent $event)
    {
        $command = $event->getCommand();
        $operation = $this->description->getOperation($command->getName());

        // For touristic object methods only
        if (in_array($operation->getName(), [
            'searchObject',
            'searchObjectIdentifier',
            'searchAgenda',
            'searchAgendaIdentifier',
            'searchDetailedAgendaIdentifier',
            'searchDetailedAgenda',
        ])) {
            $data = is_array($command['query']) ? $command['query'] : Utils::jsonDecode($command['query'], true);

            if (!empty($this->config['responseFields']) && !isset($data['responseFields'])) {
                $data['responseFields'] = $this->config['responseFields'];
            }

            if (!empty($this->config['locales']) && !isset($data['locales'])) {
                $data['locales'] = $this->config['locales'];
            }

            if (!empty($this->config['count']) && !isset($data['count'])) {
                $data['count'] = $this->config['count'];
            }

            $command['query'] = json_encode($data);
        }
    }
}
