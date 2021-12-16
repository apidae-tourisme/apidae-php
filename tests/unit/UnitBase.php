<?php

namespace ApidaePHP\Tests\Unit;

use ApidaePHP\Client;
use ApidaePHP\Tests\Base;
use GuzzleHttp\Middleware;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;

class UnitBase extends Base
{
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
}
