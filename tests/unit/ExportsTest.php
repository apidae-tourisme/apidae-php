<?php

/**
 * confirmExport
 */

namespace ApidaePHP\Tests\Unit;

use GuzzleHttp\Psr7\Response;
use ApidaePHP\Tests\Unit\UnitBase;

class ExportsTest extends UnitBase
{
    /*
    public function testgetExportFiles()
    {
        $exportFiles = $this->client->getExportFiles(['url' => 'http://export.apidae-tourisme.com/exports/5582_20211227-0159_0Dfgjb.zip']);
        $transaction = $this->lastTransaction();
        $this->markTestIncomplete();
    }
    */

    public function testconfirmExport()
    {
        /**
         * http://api.apidae-tourisme.com/api/v002/export/confirmation?hash=5582_20210427-0238_LK0LpW
         */
        $this->setMock(new Response(200, [], '{}'));
        $confirmation = $this->client->confirmExport(['hash' => '5582_20210427-0238_LK0LpW']);
        $transaction = $this->lastTransaction();
        $this->assertEquals('/api/v002/export/confirmation', $transaction['request']->getUri()->getPath());
        $this->assertEquals(['hash' => '5582_20210427-0238_LK0LpW'], $transaction['request']->query);
    }
}
