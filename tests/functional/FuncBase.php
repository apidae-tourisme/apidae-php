<?php

namespace ApidaePHP\Tests\Functional;

use ApidaePHP\Client;
use ApidaePHP\Tests\Base;
use GuzzleHttp\Middleware;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;

class FuncBase extends Base
{
    /** @see https://docs.guzzlephp.org/en/5.3/testing.html */
    public function setUp(): void
    {
        $this->container = [];
        $history = Middleware::history($this->container);
        $handlerStack = HandlerStack::create();
        $handlerStack->push($history);

        include(realpath(dirname(__FILE__)) . '/../../config.inc.php');

        $this->client = new Client(array_merge($config, ['handler' => $handlerStack]));
    }
}
