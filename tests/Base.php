<?php

namespace Sitra\Tests;

use GuzzleHttp\Message\Response;
use GuzzleHttp\Subscriber\History;
use GuzzleHttp\Subscriber\Mock;
use Sitra\ApiClient\Client;

abstract class Base extends \PHPUnit_Framework_TestCase
{
    protected $defaultOptions = [
        'apiKey' => 'XXX',
        'projectId' => 'XXX',
    ];

    protected $defaultExpected = [
        'apiKey' => 'XXX',
        'projetId' => 'XXX',
    ];

    /**
     * @var \Sitra\ApiClient\Client
     */
    protected $client;

    /**
     * @var \GuzzleHttp\Subscriber\History
     */
    protected $history;

    protected function getClient($requestCount = 1, $options = null)
    {
        $client = new Client($options ?: $this->defaultOptions);

        $history = new History();
        $client->getHttpClient()->getEmitter()->attach($history);

        $mocks = [];
        while (count($mocks) < $requestCount) {
            $mocks[] = new Response(200);
        }
        $client->getHttpClient()->getEmitter()->attach(new Mock($mocks));

        $this->client = $client;
        $this->history = $history;

        return $client;
    }
}
