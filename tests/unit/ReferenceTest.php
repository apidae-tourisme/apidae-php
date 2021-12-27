<?php

/**
 * getReferenceCity
 * getReferenceElement
 * getReferenceInternalCriteria
 * getReferenceSelection
 */

namespace ApidaePHP\Tests\Unit;

use GuzzleHttp\Psr7\Response;
use ApidaePHP\Tests\Unit\UnitBase;

class ReferenceTest extends UnitBase
{
    public function testgetReferenceCity()
    {
        $methods = ['getReferenceCity', 'referentielCommunes'];
        foreach ($methods as $method) {
            $this->setMock(new Response(200, [], '{}'));
            $this->client->$method(['query' => ['communeIds' => [36866]]]);
            $transaction = $this->lastTransaction();
            $this->assertEquals('POST', $transaction['request']->getMethod());
            $this->assertEquals('/api/v002/referentiel/communes', $transaction['request']->getUri()->getPath());
            $this->assertEquals([], $transaction['request']->query);
            $this->assertEquals(['communeIds' => [36866]], $transaction['request']->bodyQuery);
        }
    }
    public function testgetReferenceElement()
    {
        $methods = ['getReferenceElement', 'referencielElementsReference'];
        foreach ($methods as $method) {
            $this->setMock(new Response(200, [], '{}'));
            $this->client->$method(['referenceId' => 1234, 'nodeId' => 'tripadvisor']);
            $transaction = $this->lastTransaction();
            $this->assertEquals('POST', $transaction['request']->getMethod());
            $this->assertEquals('/api/v002/referentiel/elements-reference', $transaction['request']->getUri()->getPath());
            $this->assertEquals([], $transaction['request']->query);
        }
    }
    public function testgetReferenceInternalCriteria()
    {
        $methods = ['getReferenceInternalCriteria', 'referentielCriteresInternes'];
        foreach ($methods as $method) {
            $this->setMock(new Response(200, [], '{}'));
            $this->client->$method(['referenceId' => 1234, 'nodeId' => 'tripadvisor']);
            $transaction = $this->lastTransaction();
            $this->assertEquals('POST', $transaction['request']->getMethod());
            $this->assertEquals('/api/v002/referentiel/criteres-internes', $transaction['request']->getUri()->getPath());
            $this->assertEquals([], $transaction['request']->query);
        }
    }
    public function testgetReferenceSelection()
    {
        $methods = ['getReferenceSelection', 'referentielSelections'];
        foreach ($methods as $method) {
            $this->setMock(new Response(200, [], '{}'));
            $this->client->$method(['id' => 1234]);
            $transaction = $this->lastTransaction();
            $this->assertEquals('POST', $transaction['request']->getMethod());
            $this->assertEquals('/api/v002/referentiel/selections', $transaction['request']->getUri()->getPath());
            $this->assertEquals([], $transaction['request']->query);
        }
    }
}
