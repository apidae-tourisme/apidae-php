<?php

namespace Sitra\ApiClient;

use GuzzleHttp\Client as BaseClient;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use Mmoreram\Extractor\Extractor;
use Mmoreram\Extractor\Filesystem\SpecificDirectory;
use Mmoreram\Extractor\Filesystem\TemporaryDirectory;
use Sitra\ApiClient\Description\Agenda;
use Sitra\ApiClient\Description\Exports;
use Sitra\ApiClient\Description\Metadata;
use Sitra\ApiClient\Description\Search;
use Sitra\ApiClient\Description\TouristicObjects;
use Sitra\ApiClient\Subscriber\AuthenticationSubscriber;

/**
 * Magic operations:
 *
 * @todo   complete this list
 * @method array getObjectById() getObjectById(array $params)
 * @method array getObjectByIdentifier() getObjectByIdentifier(array $params)
 *
 * @method array getMetadata() getMetadata(array $params)
 * @method array deleteMetadata() deleteMetadata(array $params)
 * @method array putMetadata() putMetadata(array $params)
 *
 * @method array confirmExport() confirmExport(array $params)
 *
 * @method array searchObject() searchObject(array $params)
 * @method array searchObjectIdentifier() searchObjectIdentifier(array $params)
 *
 * @method array searchAgenda() searchAgenda(array $params)
 * @method array searchAgendaIdentifier() searchAgendaIdentifier(array $params)
 * @method array searchDetailedAgenda() searchDetailedAgenda(array $params)
 * @method array searchDetailedAgendaIdentifier() searchDetailedAgendaIdentifier(array $params)
 */
class Client extends GuzzleClient
{
    protected $config = [
        'baseUrl'       => 'http://api.sitra-tourisme.com/',
        'apiKey'        => null,
        'projectId'     => null,
        'OAuthClientId' => null,
        'OAuthSecret'   => null,
    ];

    /**
     * @todo  expose options for the Guzzle client like timeout
     * @todo  validate $config params
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = array_merge($this->config, $config);

        $client = new BaseClient(['base_url' => $this->config['baseUrl']]);

        $operations = array_merge(
            TouristicObjects::$operations,
            Metadata::$operations,
            Exports::$operations,
            Search::$operations,
            Agenda::$operations
        );

        $descriptionData = [
            'baseUrl' => $this->config['baseUrl'],
            'operations' => $operations,
            'models' => [
                'getResponse' => [
                    'type' => 'object',
                    'additionalProperties' => [
                        'location' => 'json',
                    ],
                ],
            ],
        ];

        $description = new Description($descriptionData);

        parent::__construct($client, $description, []);

        $this->getEmitter()->attach(
            new AuthenticationSubscriber($description, $this->config, $this->getHttpClient())
        );
    }

    /**
     * Download and read zip export
     *
     * @param array $params
     * @return \Symfony\Component\Finder\Finder
     */
    public function getExportFiles(array $params)
    {
        $client = $this->getHttpClient();

        if (empty($params['url'])) {
            throw new \InvalidArgumentException("Missing 'url' parameter! Must be the 'urlRecuperation' you got from the notification.");
        }

        if (preg_match('/\.zip$/i', $params['url']) !== 1) {
            throw new \InvalidArgumentException("'url' parameter does not looks good! Must be the 'urlRecuperation' you got from the notification.");
        }

        $temporaryDirectory = new TemporaryDirectory();
        $zipFullPath        = sprintf('%s/export.zip', $temporaryDirectory->getDirectoryPath());
        $exportFullPath     = sprintf('%s/export/', $temporaryDirectory->getDirectoryPath());
        mkdir($temporaryDirectory->getDirectoryPath());
        mkdir($exportFullPath);

        // Download the ZIP file in temp directory
        $response = $client->get($params['url'], ['stream' => true]);
        file_put_contents($zipFullPath, $response->getBody());

        // Extract the ZIP file
        $extractor = new Extractor(
            new SpecificDirectory($exportFullPath)
        );

        return $extractor->extractFromFile($zipFullPath);
    }
}
