<?php

/**
 * getEditAutorisation
 */

namespace ApidaePHP\Tests\Functional;

use ApidaePHP\Tests\Functional\FuncBase;

class EditTest extends FuncBase
{
    public function testgetEditAutorisation()
    {
        $methods = ['getEditAutorisation', 'autorisationObjetTouristiqueModification'];
        foreach ($methods as $method) {
            /** @var string $result */
            $result = $this->client->$method(['id' => 1234]);
            $transaction = $this->lastTransaction();

            $this->assertTrue(is_string($result));
            $this->assertEquals(200, $transaction['response']->getStatusCode());
        }
    }
}
