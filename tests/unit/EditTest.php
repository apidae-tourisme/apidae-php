<?php

namespace ApidaePHP\Tests\Unit;

use GuzzleHttp\Psr7\Response;
use ApidaePHP\Tests\Unit\UnitBase;

class EditTest extends UnitBase
{
    public function testgetEditAutorisation()
    {
        $methods = ['getEditAutorisation', 'autorisationObjetTouristiqueModification'];
        foreach ($methods as $method) {
            $this->setMock(new Response(200, [], '{}'));
            $this->client->$method(['id' => 1234, 'id2' => 'test']);
            $transaction = $this->lastTransaction();
            $this->assertEquals('GET', $transaction['request']->getMethod());
            $this->assertEquals('/api/v002/autorisation/objet-touristique/modification/1234', $transaction['request']->getUri()->getPath());
            //$this->assertEquals([], $transaction['request']->query);
        }
    }
}
