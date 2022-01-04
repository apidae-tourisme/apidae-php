<?php

/**
 * getSsoToken
 * oauthToken
 * refreshSsoToken
 */

namespace ApidaePHP\Tests\Unit;

use GuzzleHttp\Psr7\Response;
use ApidaePHP\Tests\Unit\UnitBase;

class SsoTest extends UnitBase
{
    public function testgetSsoToken()
    {
        $methods = ['getSsoToken', 'oauthToken'];
        foreach ($methods as $method) {
            $this->setMock(new Response(200, [], '{}'));
            $this->client->$method(['code' => 'uuid', 'redirect_uri' => 'https://www.test.com/']);
            $transaction = $this->lastTransaction();
            $this->assertEquals('GET', $transaction['request']->getMethod());
            $this->assertEquals('/oauth/token', $transaction['request']->getUri()->getPath());
            $this->assertEquals([
                'grant_type' => 'authorization_code',
                'code' => 'uuid',
                'redirect_uri' => 'https://www.test.com/'
            ], $transaction['request']->query);
        }
    }
    public function testrefreshSsoToken()
    {
        $methods = ['refreshSsoToken'];
        foreach ($methods as $method) {
            $this->setMock(new Response(200, [], '{}'));
            $this->client->$method(['refresh_token' => 'uuid', 'redirect_uri' => 'https://www.test.com/']);
            $transaction = $this->lastTransaction();
            $this->assertEquals('GET', $transaction['request']->getMethod());
            $this->assertEquals('/oauth/token', $transaction['request']->getUri()->getPath());
            $this->assertEquals([
                'grant_type' => 'refresh_token',
                'refresh_token' => 'uuid',
                'redirect_uri' => 'https://www.test.com/'
            ], $transaction['request']->query);
        }
    }
}
