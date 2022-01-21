<?php

/**
 * searchAgenda
 * searchAgendaIdentifier
 * searchDetailedAgenda
 * searchDetailedAgendaIdentifier
 */

namespace ApidaePHP\Tests\Functional;

use ApidaePHP\Tests\Functional\FuncBase;
use GuzzleHttp\Psr7\Response;

class AgendaTest extends FuncBase
{
    public function testsearchAgenda()
    {
        $result = $this->client->agendaSimpleListObjetsTouristiques(['query' => ['searchQuery' => 'vélo', 'count' => 61, 'responseFields' => ['nom', 'localisation']]]);
        $this->assertEquals('v002', $result['formatVersion']);
        $this->assertEquals('vélo', $result['query']['searchQuery']);
        $this->assertEquals(61, $result['query']['count']);
        $this->assertEquals(61, sizeof($result['objetsTouristiques']));
        $this->assertTrue($result['numFound'] > 400);
        $this->assertTrue(isset($result['objetsTouristiques'][0]['type']));
        $this->assertTrue(isset($result['objetsTouristiques'][0]['localisation']['adresse']['commune']));
    }

    public function testsearchAgendaIdentifier()
    {
        $result = $this->client->agendaSimpleListIdentifiants(['query' => ['searchQuery' => 'vélo', 'count' => 61, 'responseFields' => ['nom', 'localisation']]]);
        $this->assertEquals('v002', $result['formatVersion']);
        $this->assertEquals('vélo', $result['query']['searchQuery']);
        $this->assertEquals(61, $result['query']['count']);
        $this->assertEquals(61, sizeof($result['objetTouristiqueIds']));
        $this->assertTrue($result['numFound'] > 400);
        $this->assertTrue(sizeof($result['objetTouristiqueIds']) == sizeof(array_filter($result['objetTouristiqueIds'], 'is_int')));
    }

    public function testsearchDetailedAgenda()
    {
        $result = $this->client->agendaDetailleListObjetsTouristiques(['query' => ['searchQuery' => 'vélo', 'count' => 61, 'responseFields' => ['nom', 'localisation']]]);
        $this->assertEquals('vélo', $result['query']['searchQuery']);
        $this->assertEquals(61, $result['query']['count']);
        $this->assertTrue($result['numFound'] > 400);
        $keys = array_keys($result['objetsTouristiques']);
        $first_date = array_shift($keys);
        $this->assertTrue(isset($result['objetsTouristiques'][$first_date][0]['type']));
        $this->assertTrue(isset($result['objetsTouristiques'][$first_date][0]['localisation']['adresse']['commune']));
    }

    public function testsearchDetailedAgendaIdentifierr()
    {
        $result = $this->client->agendaDetailleListIdentifiants(['query' => ['searchQuery' => 'vélo', 'count' => 61, 'responseFields' => ['nom', 'localisation']]]);
        $this->assertEquals('vélo', $result['query']['searchQuery']);
        $this->assertEquals(61, $result['query']['count']);
        $this->assertTrue($result['numFound'] > 400);
        $keys = array_keys($result['objetTouristiqueIds']);
        $first_date = array_shift($keys);
        $this->assertMatchesRegularExpression('#^[0-9]{4}-[0-9]{2}-[0-9]{2}$#', $first_date);
        $this->assertEquals(sizeof($result['objetTouristiqueIds'][$first_date]), sizeof(array_filter($result['objetTouristiqueIds'][$first_date], 'is_int')));
    }
}
