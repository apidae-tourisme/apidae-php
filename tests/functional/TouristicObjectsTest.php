<?php

/**
 * getObjectById
 * getObjectByIdentifier
 */

namespace ApidaePHP\Tests\Functional;

use GuzzleHttp\Psr7\Response;
use ApidaePHP\Tests\Functional\FuncBase;

class TouristicObjectsTest extends FuncBase
{
    /**
     * @testdox Sérialisation JSON
     * --dataProvider objetDemoSimple
     */
    public function testObjetSimple()
    {
        /** @var array $objetDemo */
        $objetDemo = $this->client->objetTouristiqueGetById(['id' => 868850, 'responseFields' => 'nom', 'locales' => 'fr,en']); //  __ TEST Commerces et Services
        $this->assertArrayHasKey('libelleEn', $objetDemo['nom'],'868850 has a nom.libelleEn');
        $this->assertFalse(isset($objetDemo['localisation']),'868850 has no localisation');
    }

    /**
     * @testdox Sérialisation JSON
     * --dataProvider objetDemoComplet
     */
    public function testObjetComplet()
    {
        /** @var array $objetDemo */
        $objetDemo = $this->client->objetTouristiqueGetById(['id' => 868850, 'responseFields' => '@all', 'locales' => 'fr,en']); //  __ TEST Commerces et Services

        $this->assertArrayHasKey('aspects', $objetDemo);
        $this->assertIsArray($objetDemo['aspects']);

        $this->assertArrayHasKey('metadonnees', $objetDemo);
        $this->assertIsArray($objetDemo['metadonnees']);
        $this->assertEquals('idProduct', $objetDemo['metadonnees'][0]['contenus'][0]['metadonnee']['idProduct']);

        $this->assertArrayHasKey('descriptifsThematises', $objetDemo['presentation']);
        $this->assertIsArray($objetDemo['presentation']['descriptifsThematises']);
        $this->assertArrayHasKey('theme', $objetDemo['presentation']['descriptifsThematises'][0]);
        $this->assertArrayHasKey('id', $objetDemo['presentation']['descriptifsThematises'][0]['theme']);
        $this->assertArrayHasKey('description', $objetDemo['presentation']['descriptifsThematises'][0]);
    }

    /*
    public function objetDemoSimple()
    {
        return $this->client->objetTouristiqueGetById(['id' => 868850, 'responseFields' => 'nom', 'locales' => 'fr,en']); //  __ TEST Commerces et Services
    }

    public function objetDemoComplet()
    {
        return $this->client->objetTouristiqueGetById(['id' => 868850, 'responseFields' => '@all', 'locales' => 'fr,en']); //  __ TEST Commerces et Services
    }
    */
}
