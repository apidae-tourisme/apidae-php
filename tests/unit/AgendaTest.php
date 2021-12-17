<?php

namespace ApidaePHP\Tests\Unit;

use ApidaePHP\Tests\Unit\UnitBase;
use GuzzleHttp\Psr7\Response;

class AgendaTest extends UnitBase
{
    public function testsearchAgenda()
    {
        $methods = ['searchAgenda', 'agendaSimpleListObjetsTouristiques'];

        foreach ($methods as $method) {
            $this->setMock(new Response(200, [], '{}'));
            $this->client->$method(['query' => '{"searchQuery": "vélo"}']);
            $transaction = $this->lastTransaction();
            $this->assertEquals('POST', $transaction['request']->getMethod());
            $this->assertEquals('/api/v002/agenda/simple/list-objets-touristiques', $transaction['request']->getUri()->getPath());
            $this->assertEquals([], $transaction['request']->query);

            $this->setMock(new Response(200, [], '{}'));
            $this->client->agendaSimpleListObjetsTouristiques(['query' => '{"searchQuery": "vélo", "count": 61, "responseFields": ["nom"]}']);
            $transaction = $this->lastTransaction();
            $this->assertEquals('POST', $transaction['request']->getMethod());
            $this->assertEquals('/api/v002/agenda/simple/list-objets-touristiques', $transaction['request']->getUri()->getPath());
            $this->assertEquals([], $transaction['request']->query);
        }
    }

    public function testsearchAgendaIdentifier()
    {
        $methods = ['searchAgendaIdentifier', 'agendaSimpleListIdentifiants'];
        foreach ($methods as $method) {
            $this->setMock(new Response(200, [], '{}'));
            $this->client->$method(['query' => '{"searchQuery": "vélo"}']);
            $transaction = $this->lastTransaction();
            $this->assertEquals('POST', $transaction['request']->getMethod());
            $this->assertEquals('/api/v002/agenda/simple/list-identifiants', $transaction['request']->getUri()->getPath());
            $this->assertEquals([], $transaction['request']->query);
        }
    }

    public function testsearchDetailedAgenda()
    {
        $methods = ['searchDetailedAgenda', 'agendaDetailleListObjetsTouristiques'];
        foreach ($methods as $method) {
            $this->setMock(new Response(200, [], '{}'));
            $this->client->$method(['query' => '{"searchQuery": "vélo"}']);
            $transaction = $this->lastTransaction();
            $this->assertEquals('POST', $transaction['request']->getMethod());
            $this->assertEquals('/api/v002/agenda/detaille/list-objets-touristiques', $transaction['request']->getUri()->getPath());
            $this->assertEquals([], $transaction['request']->query);
        }
    }

    public function testsearchDetailedAgendaIdentifierr()
    {
        $methods = ['searchDetailedAgendaIdentifier', 'agendaDetailleListIdentifiants'];
        foreach ($methods as $method) {
            $this->setMock(new Response(200, [], '{}'));
            $this->client->$method(['query' => '{"searchQuery": "vélo"}']);
            $transaction = $this->lastTransaction();
            $this->assertEquals('POST', $transaction['request']->getMethod());
            $this->assertEquals('/api/v002/agenda/detaille/list-identifiants', $transaction['request']->getUri()->getPath());
            $this->assertEquals([], $transaction['request']->query);
        }
        $this->markTestIncomplete();
    }
}
