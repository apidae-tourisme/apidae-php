<?php

namespace Sitra\ApiClient\Subscriber;

use GuzzleHttp\Command\CommandInterface;
use GuzzleHttp\Command\Guzzle\DescriptionInterface;
use Sitra\ApiClient\Client as ClientApi ;

/**
 * Class AuthenticationHandler
 *
 * @package Sitra\ApiClient\Middleware
 * @author Stefan Kowalke <blueduck@mailbox.org>
 */
class AuthenticationSubscriber
{
    private $description;
    private $clientApi;
    const META_SCOPE = 'api_metadonnees';
    const SSO_SCOPE  = 'sso';
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
            if ($operation->hasParam('apiKey') && !isset($command['apiKey'])) {
                $command['apiKey'] = $this->clientApi->config('apiKey');
            }
            if ($operation->hasParam('projetId') && !isset($command['projetId'])) {
                $command['projetId'] = $this->clientApi->config('projectId');
            }
            // Search operations use the authentication inside a query string JSON!
            if (in_array($operation->getName(), [
              'searchObject',
              'searchObjectIdentifier',
              'searchAgenda',
              'searchAgendaIdentifier',
              'searchDetailedAgendaIdentifier',
              'searchDetailedAgenda',
              'getReferenceCity',
              'getReferenceElement',
              'getReferenceInternalCriteria',
              'getReferenceSelection',
            ])) {
                $data = is_array($command['query']) ? $command['query'] : \GuzzleHttp\json_decode($command['query'], true);
                if (!isset($data['apiKey']) && !isset($data['projetId'])) {
                    $data['apiKey'] = $this->clientApi->config('apiKey');
                    $data['projetId'] = $this->clientApi->config('projectId');
                    $command['query'] = json_encode($data);
                }
            }
            return $handler($command);
        };
    }
}
