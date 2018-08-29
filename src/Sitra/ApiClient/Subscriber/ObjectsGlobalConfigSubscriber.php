<?php

namespace Sitra\ApiClient\Subscriber;

use GuzzleHttp\Command\CommandInterface;
use GuzzleHttp\Command\Guzzle\DescriptionInterface;

/**
 * Class ObjectsGlobalConfigHandler
 *
 * @package Sitra\ApiClient\Middleware
 * @author Stefan Kowalke <blueduck@mailbox.org>
 */
class ObjectsGlobalConfigSubscriber
{
    /** @var DescriptionInterface $description */
    private $description;

    /** @var array $config */
    private $config = [];

    public function __construct(DescriptionInterface $description, array $config)
    {
        $this->description  = $description;
        $this->config       = $config;
    }

    /**
     * @param callable $handler
     * @return \Closure
     */
    public function __invoke(callable $handler) : \Closure
    {
        return function (CommandInterface $command) use ($handler) {
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
                $data = is_array($command['query']) ? $command['query'] : \GuzzleHttp\json_decode($command['query'], true);

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

            return $handler($command);
        };
    }
}