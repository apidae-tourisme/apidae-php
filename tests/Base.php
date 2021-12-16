<?php

namespace ApidaePHP\Tests;

use ApidaePHP\Client;
use GuzzleHttp\Middleware;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Handler\MockHandler;

class Base extends TestCase
{
    protected array $container;
    protected MockHandler $mock;
    protected Client $client;
    protected static array $config = [
        'apiKey' => '1',
        'projetId' => 1
    ];

    /** @see https://docs.guzzlephp.org/en/5.3/testing.html */
    public function setUp(): void
    {
        $this->container = [];

        $this->mock = new MockHandler([]);
        $history = Middleware::history($this->container);

        $handlerStack = HandlerStack::create($this->mock);
        $handlerStack->push($history);
        $this->client = new Client(array_merge(self::$config, ['handler' => $handlerStack]));
    }

    public function setMock(Response $response): void
    {
        $this->mock->reset();
        $this->mock->append($response);
    }

    public function lastTransaction(): array
    {
        $transaction = array_pop($this->container);
        if (($temp = $transaction['request']->getUri()->getQuery()) !== false) {
            parse_str($transaction['request']->getUri()->getQuery(), $query);
            unset($query['apiKey']);
            unset($query['projetId']);
            $transaction['request']->query = $query;
        }
        return $transaction;
    }
}
