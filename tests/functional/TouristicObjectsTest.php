<?php

/**
 * getObjectById
 * getObjectByIdentifier
 */

namespace ApidaePHP\Tests\Functional;

use ApidaePHP\Tests\Functional\FuncBase;
use GuzzleHttp\Psr7\Response;

class TouristicObjectsTest extends FuncBase
{
    public function testgetObjectById()
    {
        $methods = ['getObjectById', 'objetTouristiqueGetById'];
        foreach ($methods as $method) {
            /** @var Result $result */
            $result = $this->client->$method(['id' => 1234]);
            $request = $this->client->getLastRequest();
            //$this->assertEquals(200, $result['response']->getStatusCode());
            //$this->assertEquals([], $transaction['request']->query);
        }
        $this->markTestIncomplete();
    }

    public function testgetObjectByIdentifier()
    {
        $methods = ['getObjectByIdentifier', 'objetTouristiqueGetByIdentifier'];
        foreach ($methods as $method) {
        }
        $this->markTestIncomplete();
    }
}
