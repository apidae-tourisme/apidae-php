<?php

namespace ApidaePHP;

use ApidaePHP\Traits\Export;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use ApidaePHP\Description\Sso;
use ApidaePHP\ApidaeSerializer;
use ApidaePHP\ApidaeSubscriber;
use ApidaePHP\Description\Edit;
use ApidaePHP\Description\User;
use ApidaePHP\Description\Agenda;
use ApidaePHP\Description\Member;
use ApidaePHP\Description\Search;
use ApidaePHP\Description\Exports;
use ApidaePHP\Description\Metadata;
use ApidaePHP\Description\Reference;
use ApidaePHP\Traits\Sso as ApidaeSso;
use GuzzleHttp\Command\ResultInterface;
use ApidaePHP\Exception\ApidaeException;
use GuzzleHttp\Command\CommandInterface;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Command\Guzzle\Description;
use ApidaePHP\Description\TouristicObjects;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use GuzzleHttp\Command\Exception\CommandException;
use ApidaePHP\Exception\InvalidMetadataFormatException;
use GuzzleHttp\Command\Exception\CommandClientException;
use GuzzleHttp\Command\Exception\CommandServerException;

/** Generated with examples/methods.php
 *
 * /api/v002/agenda/simple/list-objets-touristiques
 * @see https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002agendasimplelist-objets-touristiques
 * @method array searchAgenda() searchAgenda([string 'query' => ["selectionIds" => [64, 5896,..],..],..]])
 * @method array agendaSimpleListObjetsTouristiques() agendaSimpleListObjetsTouristiques([string 'query' => ["selectionIds" => [64, 5896,..],..],..]])
 *
 * /api/v002/agenda/simple/list-identifiants
 * @see https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002agendasimplelist-identifiants
 * @method array searchAgendaIdentifier() searchAgendaIdentifier([string 'query' => ["selectionIds" => [64, 5896,..],..],..]])
 * @method array agendaSimpleListIdentifiants() agendaSimpleListIdentifiants([string 'query' => ["selectionIds" => [64, 5896,..],..],..]])
 *
 * /api/v002/agenda/detaille/list-objets-touristiques
 * @see https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002agendadetaillelist-objets-touristiques
 * @method array searchDetailedAgenda() searchDetailedAgenda([string 'query' => ["selectionIds" => [64, 5896,..],..],..]])
 * @method array agendaDetailleListObjetsTouristiques() agendaDetailleListObjetsTouristiques([string 'query' => ["selectionIds" => [64, 5896,..],..],..]])
 *
 * /api/v002/agenda/detaille/list-identifiants
 * @see https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002agendadetaillelist-identifiants
 * @method array searchDetailedAgendaIdentifier() searchDetailedAgendaIdentifier([string 'query' => ["selectionIds" => [64, 5896,..],..],..]])
 * @method array agendaDetailleListIdentifiants() agendaDetailleListIdentifiants([string 'query' => ["selectionIds" => [64, 5896,..],..],..]])
 *
 * /api/v002/autorisation/objet-touristique/modification/{id}
 * @see https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-decriture/v002autorisationobjet-touristiquemodification
 * @method array getEditAutorisation() getEditAutorisation([integer 'id' => [0-9]+, ?string 'tokenSSO' => '...'])
 * @method array autorisationObjetTouristiqueModification() autorisationObjetTouristiqueModification([integer 'id' => [0-9]+, ?string 'tokenSSO' => '...'])
 *
 * /api/v002/export/confirmation
 * @see https://dev.apidae-tourisme.com/fr/documentation-technique/v2/exports/notificationi-traitement-confirmation
 * @method array confirmExport() confirmExport([string 'hash' => '...'])
 * @method array exportConfirmation() exportConfirmation([string 'hash' => '...'])
 *
 * /api/v002/membre/get-by-id/{id}
 * @see https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002membreget-by-id-2
 * @method array getMemberById() getMemberById([integer 'id' => [0-9]+])
 * @method array membreGetById() membreGetById([integer 'id' => [0-9]+])
 *
 * /api/v002/membre/get-membres
 * @see https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002membreget-membres
 * @method array getMembers() getMembers([string 'query' => ["selectionIds" => [64, 5896,..],..],..]])
 * @method array membreGetMembres() membreGetMembres([string 'query' => ["selectionIds" => [64, 5896,..],..],..]])
 *
 * /api/v002/utilisateur/get-by-id/{id}
 * @see https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002utilisateurget-by-id
 * @method array getUserById() getUserById([integer 'id' => [0-9]+])
 * @method array utilisateurGetById() utilisateurGetById([integer 'id' => [0-9]+])
 *
 * /api/v002/utilisateur/get-by-mail/{eMail}
 * @see https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002utilisateurget-by-mail
 * @method array getUserByMail() getUserByMail([string 'eMail' => 'test@test.com'])
 * @method array utilisateurGetByMail() utilisateurGetByMail([string 'eMail' => 'test@test.com'])
 *
 * /api/v002/utilisateur/get-by-membre/{membre_id}
 * @see https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002utilisateurget-by-membre
 * @method array getUsersByMember() getUsersByMember([integer 'membre_id' => [0-9]+])
 * @method array utilisateurGetByMembre() utilisateurGetByMembre([integer 'membre_id' => [0-9]+])
 *
 * /api/v002/metadata/{referenceId}/{nodeId}{/targetType}{/targetId}
 * @see https://dev.apidae-tourisme.com/fr/documentation-technique/v2/metadonnees/web-service
 * @method array getMetadata() getMetadata([integer 'referenceId' => [0-9]+, string 'nodeId' => '...', ?string 'targetType' => '...', ?integer 'targetId' => [0-9]+])
 * @method array deleteMetadata() deleteMetadata([integer 'referenceId' => [0-9]+, string 'nodeId' => '...', ?string 'targetType' => 'general|membre|projet', ?integer 'targetId' => [0-9]+])
 *
 * /api/v002/metadata/{referenceId}/{nodeId}
 * @see https://dev.apidae-tourisme.com/fr/documentation-technique/v2/metadonnees/web-service
 * @method array putMetadata() putMetadata([integer 'referenceId' => [0-9]+, string 'nodeId' => 'tripadvisor|opensystem|...', ?string 'general' => '...', ?string 'membres' => '...', ?string 'projets' => '...', ?string 'node' => '...'])
 *
 * /api/v002/referentiel/communes
 * @see https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielcommunes
 * @method array getReferenceCity() getReferenceCity([string 'query' => ["selectionIds" => [64, 5896,..],..],..]])
 * @method array referentielCommunes() referentielCommunes([string 'query' => ["selectionIds" => [64, 5896,..],..],..]])
 *
 * /api/v002/referentiel/elements-reference
 * @see https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielelements-reference
 * @method array getReferenceElement() getReferenceElement([string 'query' => ["selectionIds" => [64, 5896,..],..],..]])
 * @method array referentielElementsReference() referentielElementsReference([string 'query' => ["selectionIds" => [64, 5896,..],..],..]])
 *
 * /api/v002/referentiel/criteres-internes
 * @see https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielcriteres-internes
 * @method array getReferenceInternalCriteria() getReferenceInternalCriteria([string 'query' => ["selectionIds" => [64, 5896,..],..],..]])
 * @method array referentielCriteresInternes() referentielCriteresInternes([string 'query' => ["selectionIds" => [64, 5896,..],..],..]])
 *
 * /api/v002/referentiel/selections
 * @see https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielselections
 * @method array getReferenceSelection() getReferenceSelection([string 'query' => ["selectionIds" => [64, 5896,..],..],..]])
 * @method array referentielSelections() referentielSelections([string 'query' => ["selectionIds" => [64, 5896,..],..],..]])
 *
 * /api/v002/referentiel/selections-par-objet
 * @see https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielselections-par-objet
 * @method array getReferenceSelectionsByObject() getReferenceSelectionsByObject([string 'query' => ["selectionIds" => [64, 5896,..],..],..]])
 * @method array referentielSelectionsParObjet() referentielSelectionsParObjet([string 'query' => ["selectionIds" => [64, 5896,..],..],..]])
 *
 * /api/v002/recherche/list-objets-touristiques
 * @see https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002recherchelist-objets-touristiques
 * @method array searchObject() searchObject([string 'query' => ["selectionIds" => [64, 5896,..],..],..]])
 * @method array rechercheListObjetsTouristiques() rechercheListObjetsTouristiques([string 'query' => ["selectionIds" => [64, 5896,..],..],..]])
 *
 * /api/v002/recherche/list-identifiants
 * @see https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002recherchelist-identifiants
 * @method array searchObjectIdentifier() searchObjectIdentifier([string 'query' => ["selectionIds" => [64, 5896,..],..],..]])
 * @method array rechercheListIdentifiants() rechercheListIdentifiants([string 'query' => ["selectionIds" => [64, 5896,..],..],..]])
 *
 * /oauth/token
 * @see https://dev.apidae-tourisme.com/fr/documentation-technique/v2/oauth/single-sign-on
 * @method array getSsoToken() getSsoToken([string 'grant_type' => 'client_credentials|authorization_code|refresh_token', string 'code' => '...', string 'redirect_uri' => 'https://myapp.com/..'])
 * @method array oauthToken() oauthToken([string 'grant_type' => 'client_credentials|authorization_code|refresh_token', string 'code' => '...', string 'redirect_uri' => 'https://myapp.com/..'])
 * @method array refreshSsoToken() refreshSsoToken([string 'grant_type' => 'client_credentials|authorization_code|refresh_token', string 'refresh_token' => '...', string 'redirect_uri' => 'https://myapp.com/..'])
 *
 * /api/v002/objet-touristique/get-by-id/{id}
 * @see https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002objet-touristiqueget-by-id
 * @method array getObjectById() getObjectById([integer 'id' => [0-9]+, ?string 'responseFields' => '@all..', ?string 'locales' => 'fr,en..'])
 * @method array objetTouristiqueGetById() objetTouristiqueGetById([integer 'id' => [0-9]+, ?string 'responseFields' => '@all..', ?string 'locales' => 'fr,en..'])
 *
 * /api/v002/objet-touristique/get-by-identifier/{identifier}
 * @see https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002objet-touristiqueget-by-identifier
 * @method array getObjectByIdentifier() getObjectByIdentifier([string 'identifier' => 'sitra1234..', ?string 'responseFields' => '@all..', ?string 'locales' => 'fr,en..'])
 * @method array objetTouristiqueGetByIdentifier() objetTouristiqueGetByIdentifier([string 'identifier' => 'sitra1234..', ?string 'responseFields' => '@all..', ?string 'locales' => 'fr,en..'])
 *
 * /api/v002/sso/utilisateur/profil
 * @see https://dev.apidae-tourisme.com/fr/documentation-technique/v2/oauth/services-associes-au-sso/v002ssoutilisateurprofil
 * @method array getUserProfile() getUserProfile()
 * @method array ssoUtilisateurProfil() ssoUtilisateurProfil()
 *
 * /api/v002/sso/utilisateur/autorisation/objet-touristique/modification/{id}
 * @see https://dev.apidae-tourisme.com/fr/documentation-technique/v2/oauth/services-associes-au-sso/v002ssoutilisateurautorisationobjet-touristiquemodification
 * @method array getUserPermissionOnObject() getUserPermissionOnObject([integer 'id' => [0-9]+])
 * @method array ssoUtilisateurAutorisationObjetTouristiqueModification() ssoUtilisateurAutorisationObjetTouristiqueModification([integer 'id' => [0-9]+])
 */
class Client extends GuzzleClient
{
  use Export;
  use ApidaeSso;

  const NAME = 'apidae-php';
  const VERSION = '2.0.0';

  const META_SCOPE = 'api_metadonnees';
  const SSO_SCOPE  = 'sso';
  const EDIT_SCOPE  = 'api_ecriture';

  /** @var array<mixed> $config */
  protected array $config = [
    'baseUri'       => 'https://api.apidae-tourisme.com/',
    'apiKey'        => null,
    'projetId'      => null,

    // Auth for metadata
    'metaClientId' => null,
    'metaSecret'   => null,

    // Auth for touristic offer edit
    'editClientId' => null,
    'editSecret'   => null,

    // Export
    'exportDir'     => '/tmp/exports/',

    // For HTTP Client
    'timeout'           => 0,
    'connectTimeout'    => 0,
    'proxy'             => null,
    'verify'            => true,

    // For SSO authentication
    'ssoBaseUrl'        => 'https://base.apidae-tourisme.com',
    'ssoRedirectUrl'    => 'http://localhost/',
    'ssoClientId'       => null,
    'ssoSecret'         => null,

    // Access tokens by scope
    'accessTokens'      => [],
  ];

  /** @var array<mixed> $operations */
  public array $operations;

  /** @var ApidaeSerializer $serializer */
  private ApidaeSerializer $serializer;

  /** @var Description $description */
  private Description $description;

  /**
   * @param array<mixed> $config
   */
  public function __construct(array $config = [])
  {
    if (isset($config['projectId'])) $config['projetId'] = $config['projectId'];

    if (isset($config['ssoToken'])) {
      $config['accessTokens'][self::SSO_SCOPE] = $config['ssoToken']['access_token'];
      unset($config['ssoToken']);
    }

    $this->config = array_merge($this->config, $config);

    $this->operations = array_merge(
      Agenda::$operations,
      Edit::$operations,
      Exports::$operations,
      Member::$operations,
      Metadata::$operations,
      Reference::$operations,
      Search::$operations,
      Sso::$operations,
      TouristicObjects::$operations,
      User::$operations,
    );

    $this->description = new Description([
      'name' => self::NAME,
      'apiVersion' => self::VERSION,
      'description' => 'PHP Helper class for Apidae Tourisme API : see https://dev.apidae-tourisme.com',
      'baseUri' => $this->config['baseUri'],
      'operations' => $this->operations,
      'models' => [
        'getResponse' => [
          'type' => 'object',
          'additionalProperties' => [
            'location' => 'json'
          ]
        ],
        'getResponseBody' => [
          'type' => 'object',
          'properties' => [
            'stream' => [
              'location' => 'body',
              'type' => 'string'
            ]
          ]
        ]
      ]
    ]);

    /**
     * custom handler is used for tests
     */
    if (isset($this->config['handler']) === false) {
      $this->config['handler'] = HandlerStack::create();
    }

    $config = array_filter([
      'base_uri' => $this->config['baseUri'],
      'timeout'           => $this->config['timeout'],
      'connect_timeout'   => $this->config['connectTimeout'],
      'proxy'             => $this->config['proxy'],
      'verify'            => $this->config['verify'],
      'handler'           => $this->config['handler'],
    ]);

    $client = new GuzzleHttpClient($config);

    $this->serializer = new ApidaeSerializer($this->description, $client, $this);
    $subscriber = new ApidaeSubscriber($this->description, $this);

    parent::__construct($client, $this->description, $this->serializer);

    $stack = $this->getHandlerStack();
    $stack->before('validate_description', $subscriber);
  }

  /**
   * Execute a single command.
   *
   * @param CommandInterface $command Command to execute
   *
   * @return ResultInterface The result of the executed command
   * @throws CommandException
   */
  public function execute(CommandInterface $command): ResultInterface|false
  {
    try {
      return $this->executeAsync($command)->wait();
    } catch (\Exception $e) {
      $this->handleHttpError($e);
    }
    return false;
  }

  /**
   * @param \Exception $e
   * @throws ApidaeException
   * @throws \Exception
   */
  private function handleHttpError(\Exception $e): void
  {
    if ($e->getPrevious() instanceof InvalidMetadataFormatException) {
      throw $e->getPrevious();
    }
    if ($e instanceof CommandClientException) {
      throw new ApidaeException($e);
    }

    if ($e instanceof CommandServerException) {
      throw new ApidaeException($e);
    }

    throw $e;
  }

  /**
   * @todo n'autoriser la récupération que des clés utiles ailleurs pour éviter toute erreur
   * @todo  Voir s'il vaut mieux lancer une erreur au lieu du return false... ?
   * @param string $var nom de la variable de conf recherchée, ex: ssoBaseUrl
   * @return mixed  Valeur de la variable de conf (ex: https://base.apidae-tourisme.com)
   */
  public function config(string $var): mixed
  {
    if (isset($this->config[$var]))
      return $this->config[$var];
    else
      return false;
  }

  public function getLastRequest(): Request
  {
    return $this->serializer->getLastRequest();
  }

  public function getOperation(string $name)
  {
    return $this->description->getOperation($name);
  }
}
