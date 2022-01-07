<?php

/**
 * getObjectById
 * getObjectByIdentifier
 */

namespace ApidaePHP\Tests\Unit;

use ApidaePHP\Tests\Unit\UnitBase;
use GuzzleHttp\Psr7\Response;

class TouristicObjectsTest extends UnitBase
{
    public function testgetObjectById()
    {
        $this->setMock(new Response(200, [], '{}'));
        $this->client->getObjectById(['id' => 1]);
        $transaction = $this->lastTransaction();
        $this->assertEquals('GET', $transaction['request']->getMethod());
        $this->assertEquals('/api/v002/objet-touristique/get-by-id/1', $transaction['request']->getUri()->getPath());
        $this->assertEquals([], $transaction['request']->query);

        $this->setMock(new Response(200, [], '{}'));
        $this->client->getObjectById(['id' => 1, 'responseFields' => '@all']);
        $transaction = $this->lastTransaction();
        $this->assertEquals('GET', $transaction['request']->getMethod());
        $this->assertEquals('/api/v002/objet-touristique/get-by-id/1', $transaction['request']->getUri()->getPath());
        $this->assertEquals(['responseFields' => '@all'], $transaction['request']->query);

        $this->setMock(new Response(200, [], '{}'));
        $this->client->getObjectById(['id' => 1, 'locales' => 'fr,en,de']);
        $transaction = $this->lastTransaction();
        $this->assertEquals('GET', $transaction['request']->getMethod());
        $this->assertEquals('/api/v002/objet-touristique/get-by-id/1', $transaction['request']->getUri()->getPath());
        $this->assertEquals(['locales' => 'fr,en,de'], $transaction['request']->query);
    }

    public function testgetObjectByIdentifier()
    {
        $this->setMock(new Response(200, [], '{}'));
        $this->client->getObjectByIdentifier(['identifier' => 'SITRA2_STR_760958']);
        $transaction = $this->lastTransaction();
        $this->assertEquals('GET', $transaction['request']->getMethod());
        $this->assertEquals('/api/v002/objet-touristique/get-by-identifier/SITRA2_STR_760958', $transaction['request']->getUri()->getPath());
        $this->assertEquals([], $transaction['request']->query);

        $this->setMock(new Response(200, [], '{}'));
        $this->client->getObjectByIdentifier(['identifier' => 'SITRA2_STR_760958', 'responseFields' => '@all']);
        $transaction = $this->lastTransaction();
        $this->assertEquals('GET', $transaction['request']->getMethod());
        $this->assertEquals('/api/v002/objet-touristique/get-by-identifier/SITRA2_STR_760958', $transaction['request']->getUri()->getPath());
        $this->assertEquals(['responseFields' => '@all'], $transaction['request']->query);

        $this->setMock(new Response(200, [], '{}'));
        $this->client->getObjectByIdentifier(['identifier' => 'SITRA2_STR_760958', 'locales' => 'fr,en,de']);
        $transaction = $this->lastTransaction();
        $this->assertEquals('GET', $transaction['request']->getMethod());
        $this->assertEquals('/api/v002/objet-touristique/get-by-identifier/SITRA2_STR_760958', $transaction['request']->getUri()->getPath());
        $this->assertEquals(['locales' => 'fr,en,de'], $transaction['request']->query);
    }
}
