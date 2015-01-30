<?php

namespace Sitra\Tests;

use GuzzleHttp\Message\Response;
use GuzzleHttp\Subscriber\History;
use GuzzleHttp\Subscriber\Mock;
use Sitra\ApiClient\Subscriber\AuthenticationSubscriber;

class MetadataTest extends Base
{
    public function testMetadata()
    {
        $client = $this->getClient(6, [
            'apiKey' => 'XXX',
            'projectId' => 'XXX',
            'accessTokens' => array(
                AuthenticationSubscriber::META_SCOPE => 'TEST'
            ),
        ]);

        $client->getMetadata(['referenceId' => 123457, 'nodeId' => 'jolicode']);

        $lastRequest = $this->history->getLastRequest();
        $this->assertEquals("/api/v002/metadata/123457/jolicode", $lastRequest->getPath());
        $this->assertEmpty($lastRequest->getQuery()->getKeys());
        $this->assertEmpty($lastRequest->getBody());
        $this->assertEquals('Bearer TEST', $lastRequest->getHeader('Authorization'));
        $this->assertEquals('GET', $lastRequest->getMethod());

        $client->putMetadata([
            'referenceId' => 123457,
            'nodeId' => 'jolicode',
            'metadata' => [
                'general' => '{"infoGenerale":"FooBar"}',
            ]
        ]);

        $lastRequest = $this->history->getLastRequest();
        $this->assertEquals("/api/v002/metadata/123457/jolicode", $lastRequest->getPath());
        $this->assertEmpty($lastRequest->getQuery()->getKeys());
        $this->assertEquals('general={"infoGenerale":"FooBar"}', urldecode((string)$lastRequest->getBody()));
        $this->assertEquals('Bearer TEST', $lastRequest->getHeader('Authorization'));
        $this->assertEquals('PUT', $lastRequest->getMethod());

        $client->putMetadata([
            'referenceId' => 123457,
            'nodeId' => 'jolicode',
            'metadata' => [
                'membres.membre_21' => '{"Foo":"Bar"}',
            ]
        ]);
        $lastRequest = $this->history->getLastRequest();
        $this->assertEquals("/api/v002/metadata/123457/jolicode", $lastRequest->getPath());
        $this->assertEmpty($lastRequest->getQuery()->getKeys());
        $this->assertEquals('membres.membre_21={"Foo":"Bar"}', urldecode((string)$lastRequest->getBody()));
        $this->assertEquals('Bearer TEST', $lastRequest->getHeader('Authorization'));
        $this->assertEquals('PUT', $lastRequest->getMethod());

        $client->deleteMetadata(['referenceId' => 123457, 'nodeId' => 'jolicode', 'targetType' => 'membre', 'targetId' => 21]);
        $lastRequest = $this->history->getLastRequest();
        $this->assertEquals("/api/v002/metadata/123457/jolicode/membre/21", $lastRequest->getPath());
        $this->assertEmpty($lastRequest->getQuery()->getKeys());
        $this->assertEmpty((string)$lastRequest->getBody());
        $this->assertEquals('Bearer TEST', $lastRequest->getHeader('Authorization'));
        $this->assertEquals('DELETE', $lastRequest->getMethod());

        $client->putMetadata([
            'referenceId' => 123457,
            'nodeId' => 'jolicode',
            'metadata' => [
                'node' => json_encode([
                    'general' => json_encode(['toto' => true, 'foo' => 'bar']),
                    'membres' => ([
                        ['targetId' => 111, 'jsonData' => json_encode(['foo' => 'barbar'])]
                    ]),
                ])
            ]
        ]);
        $expected = 'node={"general":"{\"toto\":true,\"foo\":\"bar\"}","membres":[{"targetId":111,"jsonData":"{\"foo\":\"barbar\"}"}]}';
        $lastRequest = $this->history->getLastRequest();
        $this->assertEquals("/api/v002/metadata/123457/jolicode", $lastRequest->getPath());
        $this->assertEmpty($lastRequest->getQuery()->getKeys());
        $this->assertEquals($expected, urldecode((string)$lastRequest->getBody()));
        $this->assertEquals('Bearer TEST', $lastRequest->getHeader('Authorization'));
        $this->assertEquals('PUT', $lastRequest->getMethod());

        $client->putMetadata([
            'referenceId' => 123457,
            'nodeId' => 'jolicode',
            'metadata' => [
                'membres' => '[{"targetId": 21, "jsonData": "{ \"foo\": \"bar\", \"bar\": 691 }" }, { "targetId": 12, "jsonData": "{ \"bar\": \"foo\" }" } ]'
            ]
        ]);
        $expected = 'membres=[{"targetId": 21, "jsonData": "{ \"foo\": \"bar\", \"bar\": 691 }" }, { "targetId": 12, "jsonData": "{ \"bar\": \"foo\" }" } ]';
        $lastRequest = $this->history->getLastRequest();
        $this->assertEquals("/api/v002/metadata/123457/jolicode", $lastRequest->getPath());
        $this->assertEmpty($lastRequest->getQuery()->getKeys());
        $this->assertEquals($expected, urldecode((string)$lastRequest->getBody()));
        $this->assertEquals('Bearer TEST', $lastRequest->getHeader('Authorization'));
        $this->assertEquals('PUT', $lastRequest->getMethod());
    }

    public function wrongJson()
    {
        return [
            [['test' => '{"infoGenerale":"FooBar"}',],],
            [['Membre' => '[{"foo\" }" } ]',],],
            [['membres.club' => '{"Foo":"Bar"}',],],
            [['membres.coucou_1' => '{"Foo":"Bar"}',],],
            [['membres.membre_1' => false,],],
        ];
    }

    /**
     * @expectedException \Sitra\ApiClient\Exception\InvalidMetadataFormatException
     * @dataProvider wrongJson
     */
    public function testWrongData($data)
    {
        $client = $this->getClient(1, [
            'apiKey' => 'XXX',
            'projectId' => 'XXX',
            'accessTokens' => array(
                AuthenticationSubscriber::META_SCOPE => 'TEST'
            ),
        ]);

        $client->putMetadata([
            'referenceId' => 123457,
            'nodeId' => 'jolicode',
            'metadata' => $data
        ]);
    }
}
