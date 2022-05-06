<?php

/**
 * getMetadata
 * deleteMetadata
 * putMetadata
 */

namespace ApidaePHP\Tests\Unit;

use GuzzleHttp\Psr7\Response;
use ApidaePHP\Tests\Unit\UnitBase;

class MetadataTest extends UnitBase
{
    public function testgetMetadata()
    {
        $methods = ['getMetadata'];
        foreach ($methods as $method) {
            $this->setMock(new Response(200, [], '{}'));
            $this->client->$method(['referenceId' => 1234, 'nodeId' => 'tripadvisor']);
            $transaction = $this->lastTransaction();
            $this->assertEquals('GET', $transaction['request']->getMethod());
            $this->assertEquals('/api/v002/metadata/1234/tripadvisor', $transaction['request']->getUri()->getPath());
            $this->assertEquals([], $transaction['request']->query);
        }
    }
    public function testdeleteMetadata()
    {
        $methods = ['deleteMetadata'];
        foreach ($methods as $method) {
            $this->setMock(new Response(200, [], '{}'));
            $this->client->$method(['referenceId' => 1234, 'nodeId' => 'tripadvisor']);
            $transaction = $this->lastTransaction();
            $this->assertEquals('DELETE', $transaction['request']->getMethod());
            $this->assertEquals('/api/v002/metadata/1234/tripadvisor', $transaction['request']->getUri()->getPath());
            $this->assertEquals([], $transaction['request']->query);
        }
    }
    public function testputMetadata()
    {
        $methods = ['putMetadata'];
        foreach ($methods as $method) {
            $this->setMock(new Response(200, [], '{}'));
            $this->client->$method(['referenceId' => 1234, 'nodeId' => 'tripadvisor']);
            $transaction = $this->lastTransaction();
            $this->assertEquals('PUT', $transaction['request']->getMethod());
            $this->assertEquals('/api/v002/metadata/1234/tripadvisor', $transaction['request']->getUri()->getPath());
            $this->assertEquals([], $transaction['request']->query);
        }
    }
}
