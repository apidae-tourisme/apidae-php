<?php

/**
 * searchObject
 * searchObjectIdentifier
 */

namespace ApidaePHP\Tests\Unit;

use GuzzleHttp\Psr7\Response;
use ApidaePHP\Tests\Unit\UnitBase;

class SearchTest extends UnitBase
{
    public function testsearchObject()
    {
        $methods = ['searchObject', 'rechercheListObjetsTouristiques'];
        foreach ($methods as $method) {
            $this->setMock(new Response(200, [], '{}'));
            $this->client->$method(['query' => ['selectionIds' => [1234]]]);
            $transaction = $this->lastTransaction();
            $this->assertEquals('POST', $transaction['request']->getMethod());
            $this->assertEquals('/api/v002/recherche/list-objets-touristiques', $transaction['request']->getUri()->getPath());
            $this->assertEquals([], $transaction['request']->query);
            $this->assertEquals(['selectionIds' => [1234]], $transaction['request']->bodyQuery);
        }
    }
    public function testsearchObjectIdentifier()
    {
        $methods = ['searchObjectIdentifier', 'rechercheListIdentifiants'];
        foreach ($methods as $method) {
            $this->setMock(new Response(200, [], '{}'));
            $this->client->$method(['query' => ['selectionIds' => [1234]]]);
            $transaction = $this->lastTransaction();
            $this->assertEquals('POST', $transaction['request']->getMethod());
            $this->assertEquals('/api/v002/recherche/list-identifiants', $transaction['request']->getUri()->getPath());
            $this->assertEquals([], $transaction['request']->query);
            $this->assertEquals(['selectionIds' => [1234]], $transaction['request']->bodyQuery);
        }
    }
}
