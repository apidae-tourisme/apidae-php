<?php

/**
 * getUserProfile
 * getUserPermissionOnObject
 */

namespace ApidaePHP\Tests\Unit;

use GuzzleHttp\Psr7\Response;
use ApidaePHP\Tests\Unit\UnitBase;

class UserTest extends UnitBase
{
    public function testgetUserProfile()
    {
        $methods = ['getUserProfile', 'ssoUtilisateurProfil'];
        foreach ($methods as $method) {
            $this->setMock(new Response(200, [], '{}'));
            $this->client->$method(['id' => 1234]);
            $transaction = $this->lastTransaction();
            $this->assertEquals('GET', $transaction['request']->getMethod());
            $this->assertEquals('/api/v002/sso/utilisateur/profil', $transaction['request']->getUri()->getPath());
            $this->assertEquals([], $transaction['request']->query);
        }
    }
    public function testgetUserPermissionOnObject()
    {
        $methods = ['getUserPermissionOnObject', 'ssoUtilisateurAutorisationObjetTouristiqueModification'];
        foreach ($methods as $method) {
            $this->setMock(new Response(200, [], '{}'));
            $this->client->$method(['id' => 1234]);
            $transaction = $this->lastTransaction();
            $this->assertEquals('GET', $transaction['request']->getMethod());
            $this->assertEquals('/api/v002/sso/utilisateur/autorisation/objet-touristique/modification/1234', $transaction['request']->getUri()->getPath());
            $this->assertEquals([], $transaction['request']->query);
        }
    }
}
