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
        'projetId' => 1,
        'accessTokens' => [
            Client::SSO_SCOPE => 'fake_token_sso',
            Client::EDIT_SCOPE => 'fake_token_edit',
            Client::META_SCOPE => 'fake_token_meta',
        ]
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
