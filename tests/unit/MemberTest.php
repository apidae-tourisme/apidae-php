<?php

/**
 * getMemberById
 * getMembers
 * getUserById
 * getUserByMail
 * getUsersByMember
 * getAllUsers
 */

namespace ApidaePHP\Tests\Unit;

use GuzzleHttp\Psr7\Response;
use ApidaePHP\Tests\Unit\UnitBase;

class MemberTest extends UnitBase
{
    public function testgetMemberById()
    {
        $methods = ['getMemberById', 'membreGetById'];
        foreach ($methods as $method) {
            $this->setMock(new Response(200, [], '{}'));
            $this->client->$method(['id' => 1234]);
            $transaction = $this->lastTransaction();
            $this->assertEquals('GET', $transaction['request']->getMethod());
            $this->assertEquals('/api/v002/membre/get-by-id/1234', $transaction['request']->getUri()->getPath());
            $this->assertEquals([], $transaction['request']->query);
        }
    }
    public function testgetMembers()
    {
        $methods = ['getMembers', 'membreGetMembres'];
        foreach ($methods as $method) {
            $this->setMock(new Response(200, [], '{}'));
            $this->client->$method(['id' => 1234]);
            $transaction = $this->lastTransaction();
            $this->assertEquals('POST', $transaction['request']->getMethod());
            $this->assertEquals('/api/v002/membre/get-membres', $transaction['request']->getUri()->getPath());
            $this->assertEquals([], $transaction['request']->query);
        }
    }
    public function testgetUserById()
    {
        $methods = ['getUserById', 'utilisateurGetById'];
        foreach ($methods as $method) {
            $this->setMock(new Response(200, [], '{}'));
            $this->client->$method(['id' => 1234]);
            $transaction = $this->lastTransaction();
            $this->assertEquals('GET', $transaction['request']->getMethod());
            $this->assertEquals('/api/v002/utilisateur/get-by-id/1234', $transaction['request']->getUri()->getPath());
            $this->assertEquals([], $transaction['request']->query);
        }
    }
    public function testgetUserByMail()
    {
        $methods = ['getUserByMail', 'utilisateurGetByMail'];
        foreach ($methods as $method) {
            $this->setMock(new Response(200, [], '{}'));
            $this->client->$method(['eMail' => 'pierre.granger@apidae-tourisme.com']);
            $transaction = $this->lastTransaction();
            $this->assertEquals('GET', $transaction['request']->getMethod());
            $this->assertEquals('/api/v002/utilisateur/get-by-mail/' . urlencode('pierre.granger@apidae-tourisme.com'), $transaction['request']->getUri()->getPath());
            $this->assertEquals([], $transaction['request']->query);
        }
    }
    public function testgetUsersByMember()
    {
        $methods = ['getUsersByMember', 'utilisateurGetByMembre'];
        foreach ($methods as $method) {
            $this->setMock(new Response(200, [], '{}'));
            $this->client->$method(['membre_id' => 1234]);
            $transaction = $this->lastTransaction();
            $this->assertEquals('GET', $transaction['request']->getMethod());
            $this->assertEquals('/api/v002/utilisateur/get-by-membre/1234', $transaction['request']->getUri()->getPath());
            $this->assertEquals([], $transaction['request']->query);
        }
    }
    /*
    public function testgetAllUsers()
    {
    }
    */
}
