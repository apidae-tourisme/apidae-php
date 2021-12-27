<?php

namespace ApidaePHP\Tests;

use ApidaePHP\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Handler\MockHandler;

class Base extends TestCase
{
    protected array $container;
    protected MockHandler $mock;
    protected Client $client;

    public function setMock(Response $response): void
    {
        $this->mock->reset();
        $this->mock->append($response);
    }

    public function lastTransaction(): array
    {
        $transaction = array_pop($this->container);

        /** @var Request $request */
        $request = $transaction['request'];

        if (($temp = $request->getUri()->getQuery()) !== false) {
            parse_str($temp, $query);
            unset($query['apiKey']);
            unset($query['projetId']);
            unset($query['tokenSSO']);
            $request->query = $query;
        }

        /**
         * query={"apiKey":"1","projetId":1}
         */
        if (($temp = $request->getBody()) !== false) {
            parse_str($temp, $body);
            $request->body = $body;
            if (isset($body['query'])) {
                $bodyQuery = json_decode($body['query'], true);
                if (json_last_error() == JSON_ERROR_NONE) {
                    unset($bodyQuery['apiKey']);
                    unset($bodyQuery['projetId']);
                    unset($bodyQuery['tokenSSO']);
                    $request->bodyQuery = $bodyQuery;
                }
            }
        }

        return $transaction;
    }
}
