<?php

namespace Sitra\ApiClient;

use GuzzleHttp\Client as BaseClient;
use GuzzleHttp\Command\Exception\CommandClientException;
use GuzzleHttp\Command\Exception\CommandException;
use GuzzleHttp\Command\Exception\CommandServerException;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Url;
use Mmoreram\Extractor\Extractor;
use Mmoreram\Extractor\Filesystem\SpecificDirectory;
use Sitra\ApiClient\Description\Agenda;
use Sitra\ApiClient\Description\Exports;
use Sitra\ApiClient\Description\Metadata;
use Sitra\ApiClient\Description\Reference;
use Sitra\ApiClient\Description\Search;
use Sitra\ApiClient\Description\Sso;
use Sitra\ApiClient\Description\TouristicObjects;
use Sitra\ApiClient\Description\User;
use Sitra\ApiClient\Exception\InvalidExportDirectoryException;
use Sitra\ApiClient\Exception\SitraException;
use Sitra\ApiClient\Subscriber\AuthenticationSubscriber;
use Sitra\ApiClient\Subscriber\ObjectsGlobalConfigSubscriber;

/**
 * Magic operations:
 *
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
 *
 * @method array getReferenceCity() getReferenceCity(array $params)
 * @method array getReferenceElement() getReferenceElement(array $params)
 * @method array getReferenceInternalCriteria() getReferenceInternalCriteria(array $params)
 * @method array getReferenceSelection() getReferenceSelection(array $params)
 *
 * @method array getSsoToken() getSsoToken(array $params)
 * @method array refreshSsoToken() refreshSsoToken(array $params)
 *
 * @method array getUserProfile() getUserProfile()
 * @method array getUserPermissionOnObject() getUserPermissionOnObject(array $params)
 */
class Client extends GuzzleClient
{
    protected $config = [
        'baseUrl'       => 'http://api.sitra-tourisme.com/',
        'apiKey'        => null,
        'projectId'     => null,

        // Auth for metadata
        'OAuthClientId' => null,
        'OAuthSecret'   => null,

        // Export
        'exportDir'     => '/tmp/sitraExports/',

        // For object lists
        'responseFields' => [],
        'locales'        => [],
        'count'          => 20,

        // For HTTP Client
        'timeout'           => 0,
        'connectTimeout'    => 0,
        'proxy'             => null,
        'verify'            => true,

        // For SSO authentication
        'ssoBaseUrl'        => 'http://base.sitra-tourisme.com',
        'ssoRedirectUrl'    => 'http://localhost/',
        'ssoClientId'       => null,
        'ssoSecret'         => null,

        // Access tokens by scope
        'accessTokens'      => [],
    ];

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = new \ArrayObject(array_merge($this->config, $config));

        $client = new BaseClient([
            'base_url' => $this->config['baseUrl'],
            'defaults' => array_filter([
                'timeout'           => $this->config['timeout'],
                'connect_timeout'   => $this->config['connectTimeout'],
                'proxy'             => $this->config['proxy'],
            ]),
            'defaults' => [
                'verify'            => $this->config['verify']
            ]
        ]);

        $operations = array_merge(
            TouristicObjects::$operations,
            Metadata::$operations,
            Exports::$operations,
            Search::$operations,
            Agenda::$operations,
            Reference::$operations,
            Sso::$operations,
            User::$operations
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

        $this->getEmitter()->attach(
            new ObjectsGlobalConfigSubscriber($description, $this->config)
        );
    }

    /**
     * Download and read zip export
     *
     * @param  array                            $params
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

        $temporaryDirectory = $this->getExportDirectory();
        $exportPath         = sprintf('%s/%s', $temporaryDirectory->getDirectoryPath(), date('Y-m-d-His'));
        $zipFullPath        = sprintf('%s/export.zip', $exportPath);
        $exportFullPath     = sprintf('%s/export/', $exportPath);

        mkdir($exportPath);
        mkdir($exportFullPath);

        // Download the ZIP file in temp directory
        try {
            $response = $client->get($params['url'], ['stream' => true]);
        } catch (\Exception $e) {
            $this->handleHttpError($e);
            return false;
        }

        // Could use save_to too
        file_put_contents($zipFullPath, $response->getBody());

        // Extract the ZIP file
        $extractor = new Extractor(
            new SpecificDirectory($exportFullPath)
        );

        return $extractor->extractFromFile($zipFullPath);
    }

    /**
     * Remove all ZIP and exported files from the exportDir (cleanup files we have created)
     */
    public function cleanExportFiles()
    {
        $exportDirectory = $this->getExportDirectory();

        $iterator = new \RecursiveDirectoryIterator(
            $exportDirectory->getDirectoryPath(),
            \RecursiveDirectoryIterator::SKIP_DOTS
        );

        $files = new \RecursiveIteratorIterator(
            $iterator,
            \RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($files as $file) {
            if ($file->isDir()) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }

        return true;
    }

    public function getSsoUrl()
    {
        $params = array(
            'response_type' => 'code',
            'client_id'     => $this->config['ssoClientId'],
            'redirect_uri'  => $this->config['ssoRedirectUrl'],
            'scope'         => AuthenticationSubscriber::SSO_SCOPE,
        );

        $url = Url::fromString($this->config['ssoBaseUrl']);
        $url->setPath('/oauth/authorize');
        $url->setQuery($params);

        return (string) $url;
    }

    public function setAccessToken($scope, $token)
    {
        $this->config['accessTokens'][$scope] = $token;
    }

    public function __call($name, array $arguments)
    {
        try {
            return parent::__call($name, $arguments);
        } catch (\Exception $e) {
            $this->handleHttpError($e);
        }

        return false;
    }

    private function handleHttpError(\Exception $e)
    {
        if ($e instanceof CommandClientException) {
            throw new SitraException($e);
        }

        if ($e instanceof CommandServerException) {
            throw new SitraException($e);
        }

        if ($e instanceof CommandException) {
            throw $e;
        }

        if ($e instanceof RequestException) {
            throw new SitraException($e);
        }

        throw $e;
    }

    private function getExportDirectory()
    {
        if (!file_exists($this->config['exportDir'])) {
            mkdir($this->config['exportDir']);
        }

        $dir = new SpecificDirectory($this->config['exportDir']);

        if (!$dir) {
            throw new InvalidExportDirectoryException();
        }

        return $dir;
    }
}
