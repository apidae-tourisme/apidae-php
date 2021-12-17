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

    public function setMock(Response $response): void
    {
        $this->mock->reset();
        $this->mock->append($response);
    }

    public function lastTransaction(): array
    {
        $transaction = array_pop($this->container);
        if (($temp = $transaction['request']->getUri()->getQuery()) !== false) {
            parse_str($temp, $query);
            unset($query['apiKey']);
            unset($query['projetId']);
            unset($query['tokenSSO']);
            $transaction['request']->query = $query;
        }
        return $transaction;
    }
}
