<?php

namespace Sitra\Tests;

use GuzzleHttp\Message\Response;
use GuzzleHttp\Subscriber\History;
use GuzzleHttp\Subscriber\Mock;

class ClientTest extends Base
{

    public function testClient()
    {
        $client = $this->getClient(3);

        // Make a request
        $client->getObjectById(['id' => 1]);

        $lastRequest = $this->history->getLastRequest();
        $this->assertEquals("/api/v002/objet-touristique/get-by-id/1", $lastRequest->getPath());
        $this->assertEquals($this->defaultExpected, $lastRequest->getQuery()->getIterator()->getArrayCopy());

        // Make a request
        $client->getObjectById(['id' => 888]);

        $lastRequest = $this->history->getLastRequest();
        $this->assertEquals("/api/v002/objet-touristique/get-by-id/888", $lastRequest->getPath());
        $this->assertEquals($this->defaultExpected, $lastRequest->getQuery()->getIterator()->getArrayCopy());

        // Make a request
        $client->getObjectByIdentifier(['identifier' => 'toto']);

        $lastRequest = $this->history->getLastRequest();
        $this->assertEquals("/api/v002/objet-touristique/get-by-identifier/toto", $lastRequest->getPath());
        $this->assertEquals($this->defaultExpected, $lastRequest->getQuery()->getIterator()->getArrayCopy());
    }
}
