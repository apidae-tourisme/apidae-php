<?php

namespace Sitra\ApiClient\Subscriber;

use GuzzleHttp\Command\CommandInterface;
use GuzzleHttp\Command\Guzzle\DescriptionInterface;
use Sitra\ApiClient\Client as ClientApi ;

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

    private $clientApi ;

    public function __construct(DescriptionInterface $description, ClientApi $clientApi)
    {
        $this->description  = $description;
        $this->clientApi       = $clientApi;
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

                if (!empty($this->clientApi->config('responseFields')) && !isset($data['responseFields'])) {
                    $data['responseFields'] = $this->clientApi->config('responseFields') ;
                }

                if (!empty($this->clientApi->config('locales')) && !isset($data['locales'])) {
                    $data['locales'] = $this->clientApi->config('locales');
                }

                if (!empty($this->clientApi->config('count')) && !isset($data['count'])) {
                    $data['count'] = $this->clientApi->config('count');
                }

                $command['query'] = json_encode($data);
            }

            return $handler($command);
        };
    }
}