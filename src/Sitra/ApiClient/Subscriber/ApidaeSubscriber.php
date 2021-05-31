<?php

namespace Sitra\ApiClient\Subscriber;

use GuzzleHttp\Command\CommandInterface;
use GuzzleHttp\Command\Guzzle\DescriptionInterface;
use Sitra\ApiClient\Client as ClientApi;

class ApidaeSubscriber
{
    private $description;
    private $clientApi;
    public function __construct(DescriptionInterface $description, ClientApi $clientApi)
    {
        $this->description  = $description;
        $this->clientApi       = $clientApi;
    }
    /**
     * @param callable $handler
     * @return \Closure
     */
    public function __invoke(callable $handler): \Closure
    {
        return function (CommandInterface $command) use ($handler) {

            $operation = $this->description->getOperation($command->getName());

            if ($operation->hasParam('apiKey') && !isset($command['apiKey'])) {
                $command['apiKey'] = $this->clientApi->config('apiKey');
            }
            if ($operation->hasParam('projetId') && !isset($command['projetId'])) {
                $command['projetId'] = $this->clientApi->config('projetId');
            }
            // Search operations use the authentication inside a query string JSON!
            if ($operation->hasParam('query')) {
                $data = is_array($command['query']) ? $command['query'] : \GuzzleHttp\json_decode($command['query'], true);
                if (!isset($data['apiKey']) && !isset($data['projetId'])) {
                    $data['apiKey'] = $this->clientApi->config('apiKey');
                    $data['projetId'] = $this->clientApi->config('projetId');

                    $command['query'] = json_encode($data);
                }
            }
            return $handler($command);
        };
    }
}
