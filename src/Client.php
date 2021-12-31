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

/* Generated with examples/methods.php */

/** 

 * @method Array searchAgenda(array $query) 
 * @return Array
 * searchAgenda(['selectionIds' => [64, 5896,..],..],..])
 * /api/v002/agenda/simple/list-objets-touristiques
 * 
 * @method Array agendaSimpleListObjetsTouristiques(array $query) 
 * @return Array
 * agendaSimpleListObjetsTouristiques(['selectionIds' => [64, 5896,..],..],..])
 * /api/v002/agenda/simple/list-objets-touristiques
 * 
 * @method Array searchAgendaIdentifier(array $query) 
 * @return Array
 * searchAgendaIdentifier(['selectionIds' => [64, 5896,..],..],..])
 * /api/v002/agenda/simple/list-identifiants
 * 
 * @method Array agendaSimpleListIdentifiants(array $query) 
 * @return Array
 * agendaSimpleListIdentifiants(['selectionIds' => [64, 5896,..],..],..])
 * /api/v002/agenda/simple/list-identifiants
 * 
 * @method Array searchDetailedAgenda(array $query) 
 * @return Array
 * searchDetailedAgenda(['selectionIds' => [64, 5896,..],..],..])
 * /api/v002/agenda/detaille/list-objets-touristiques
 * 
 * @method Array agendaDetailleListObjetsTouristiques(array $query) 
 * @return Array
 * agendaDetailleListObjetsTouristiques(['selectionIds' => [64, 5896,..],..],..])
 * /api/v002/agenda/detaille/list-objets-touristiques
 * 
 * @method Array searchDetailedAgendaIdentifier(array $query) 
 * @return Array
 * searchDetailedAgendaIdentifier(['selectionIds' => [64, 5896,..],..],..])
 * /api/v002/agenda/detaille/list-identifiants
 * 
 * @method Array agendaDetailleListIdentifiants(array $query) 
 * @return Array
 * agendaDetailleListIdentifiants(['selectionIds' => [64, 5896,..],..],..])
 * /api/v002/agenda/detaille/list-identifiants
 * 
 * @method Array getEditAutorisation(integer $id, string $tokenSSO) 
 * @return Array
 * getEditAutorisation([0-9]+, ?'...')
 * /api/v002/autorisation/objet-touristique/modification/{id}
 * 
 * @method Array autorisationObjetTouristiqueModification(integer $id, string $tokenSSO) 
 * @return Array
 * autorisationObjetTouristiqueModification([0-9]+, ?'...')
 * /api/v002/autorisation/objet-touristique/modification/{id}
 * 
 * @method Array confirmExport(string $hash) 
 * @return Array
 * confirmExport('...')
 * /api/v002/export/confirmation
 * 
 * @method Array exportConfirmation(string $hash) 
 * @return Array
 * exportConfirmation('...')
 * /api/v002/export/confirmation
 * 
 * @method Array getMemberById(integer $id, string $apiKey, string $projetId) 
 * @return Array
 * getMemberById([0-9]+)
 * /api/v002/membre/get-by-id/{id}
 * 
 * @method Array membreGetById(integer $id, string $apiKey, string $projetId) 
 * @return Array
 * membreGetById([0-9]+)
 * /api/v002/membre/get-by-id/{id}
 * 
 * @method Array getMembers(array $query) 
 * @return Array
 * getMembers(['selectionIds' => [64, 5896,..],..],..])
 * /api/v002/membre/get-membres
 * 
 * @method Array membreGetMembres(array $query) 
 * @return Array
 * membreGetMembres(['selectionIds' => [64, 5896,..],..],..])
 * /api/v002/membre/get-membres
 * 
 * @method Array getUserById(integer $id, string $apiKey, string $projetId) 
 * @return Array
 * getUserById([0-9]+)
 * /api/v002/utilisateur/get-by-id/{id}
 * 
 * @method Array utilisateurGetById(integer $id, string $apiKey, string $projetId) 
 * @return Array
 * utilisateurGetById([0-9]+)
 * /api/v002/utilisateur/get-by-id/{id}
 * 
 * @method Array getUserByMail(string $eMail, string $apiKey, string $projetId) 
 * @return Array
 * getUserByMail('test@test.com')
 * /api/v002/utilisateur/get-by-mail/{eMail}
 * 
 * @method Array utilisateurGetByMail(string $eMail, string $apiKey, string $projetId) 
 * @return Array
 * utilisateurGetByMail('test@test.com')
 * /api/v002/utilisateur/get-by-mail/{eMail}
 * 
 * @method Array getUsersByMember(integer $membre_id, string $apiKey, string $projetId) 
 * @return Array
 * getUsersByMember([0-9]+)
 * /api/v002/utilisateur/get-by-membre/{membre_id}
 * 
 * @method Array utilisateurGetByMembre(integer $membre_id, string $apiKey, string $projetId) 
 * @return Array
 * utilisateurGetByMembre([0-9]+)
 * /api/v002/utilisateur/get-by-membre/{membre_id}
 * 
 * @method Array getMetadata(integer $referenceId, string $nodeId, string $targetType, integer $targetId) 
 * @return Array
 * getMetadata([0-9]+, '...', ?'general|membre|projet', ?[0-9]+)
 * /api/v002/metadata/{referenceId}/{nodeId}{/targetType}{/targetId}
 * 
 * @method Array deleteMetadata(integer $referenceId, string $nodeId, string $targetType, integer $targetId) 
 * @return Array
 * deleteMetadata([0-9]+, '...', ?'general|membre|projet', ?[0-9]+)
 * /api/v002/metadata/{referenceId}/{nodeId}{/targetType}{/targetId}
 * 
 * @method Array putMetadata(integer $referenceId, string $nodeId, string $general, string $membres, string $projets, string $node) 
 * @return Array
 * putMetadata([0-9]+, '...', ?'...', ?'...', ?'...', ?'...')
 * /api/v002/metadata/{referenceId}/{nodeId}
 * 
 * @method Array getReferenceCity(array $query) 
 * @return Array
 * getReferenceCity(['selectionIds' => [64, 5896,..],..],..])
 * /api/v002/referentiel/communes
 * 
 * @method Array referentielCommunes(array $query) 
 * @return Array
 * referentielCommunes(['selectionIds' => [64, 5896,..],..],..])
 * /api/v002/referentiel/communes
 * 
 * @method Array getReferenceElement(array $query) 
 * @return Array
 * getReferenceElement(['selectionIds' => [64, 5896,..],..],..])
 * /api/v002/referentiel/elements-reference
 * 
 * @method Array referentielElementsReference(array $query) 
 * @return Array
 * referentielElementsReference(['selectionIds' => [64, 5896,..],..],..])
 * /api/v002/referentiel/elements-reference
 * 
 * @method Array getReferenceInternalCriteria(array $query) 
 * @return Array
 * getReferenceInternalCriteria(['selectionIds' => [64, 5896,..],..],..])
 * /api/v002/referentiel/criteres-internes
 * 
 * @method Array referentielCriteresInternes(array $query) 
 * @return Array
 * referentielCriteresInternes(['selectionIds' => [64, 5896,..],..],..])
 * /api/v002/referentiel/criteres-internes
 * 
 * @method Array getReferenceSelection(array $query) 
 * @return Array
 * getReferenceSelection(['selectionIds' => [64, 5896,..],..],..])
 * /api/v002/referentiel/selections
 * 
 * @method Array referentielSelections(array $query) 
 * @return Array
 * referentielSelections(['selectionIds' => [64, 5896,..],..],..])
 * /api/v002/referentiel/selections
 * 
 * @method Array getReferenceSelectionsByObject(array $query) 
 * @return Array
 * getReferenceSelectionsByObject(['selectionIds' => [64, 5896,..],..],..])
 * /api/v002/referentiel/selections-par-objet
 * 
 * @method Array referentielSelectionsParObjet(array $query) 
 * @return Array
 * referentielSelectionsParObjet(['selectionIds' => [64, 5896,..],..],..])
 * /api/v002/referentiel/selections-par-objet
 * 
 * @method Array searchObject(array $query) 
 * @return Array
 * searchObject(['selectionIds' => [64, 5896,..],..],..])
 * /api/v002/recherche/list-objets-touristiques
 * 
 * @method Array rechercheListObjetsTouristiques(array $query) 
 * @return Array
 * rechercheListObjetsTouristiques(['selectionIds' => [64, 5896,..],..],..])
 * /api/v002/recherche/list-objets-touristiques
 * 
 * @method Array searchObjectIdentifier(array $query) 
 * @return Array
 * searchObjectIdentifier(['selectionIds' => [64, 5896,..],..],..])
 * /api/v002/recherche/list-identifiants
 * 
 * @method Array rechercheListIdentifiants(array $query) 
 * @return Array
 * rechercheListIdentifiants(['selectionIds' => [64, 5896,..],..],..])
 * /api/v002/recherche/list-identifiants
 * 
 * @method Array getSsoToken(string $grant_type, string $code, string $redirect_uri) 
 * @return Array
 * getSsoToken('authorization_code|client_credentials|refresh_token', '...', 'https://myapp.com/..')
 * /oauth/token
 * 
 * @method Array oauthToken(string $grant_type, string $code, string $redirect_uri) 
 * @return Array
 * oauthToken('authorization_code|client_credentials|refresh_token', '...', 'https://myapp.com/..')
 * /oauth/token
 * 
 * @method Array refreshSsoToken(string $grant_type, string $refresh_token, string $redirect_uri) 
 * @return Array
 * refreshSsoToken('authorization_code|client_credentials|refresh_token', '...', 'https://myapp.com/..')
 * /oauth/token
 * 
 * @method Array getObjectById(integer $id, string $responseFields, string $locales, string $apiKey, string $projetId) 
 * @return Array
 * getObjectById([0-9]+, ?'@all..', ?'fr,en..')
 * /api/v002/objet-touristique/get-by-id/{id}
 * 
 * @method Array objetTouristiqueGetById(integer $id, string $responseFields, string $locales, string $apiKey, string $projetId) 
 * @return Array
 * objetTouristiqueGetById([0-9]+, ?'@all..', ?'fr,en..')
 * /api/v002/objet-touristique/get-by-id/{id}
 * 
 * @method Array getObjectByIdentifier(string $identifier, string $responseFields, string $locales, string $apiKey, string $projetId) 
 * @return Array
 * getObjectByIdentifier('sitra1234..', ?'@all..', ?'fr,en..')
 * /api/v002/objet-touristique/get-by-identifier/{identifier}
 * 
 * @method Array objetTouristiqueGetByIdentifier(string $identifier, string $responseFields, string $locales, string $apiKey, string $projetId) 
 * @return Array
 * objetTouristiqueGetByIdentifier('sitra1234..', ?'@all..', ?'fr,en..')
 * /api/v002/objet-touristique/get-by-identifier/{identifier}
 * 
 * @method Array getUserProfile() 
 * @return Array
 * /api/v002/sso/utilisateur/profil
 * 
 * @method Array ssoUtilisateurProfil() 
 * @return Array
 * /api/v002/sso/utilisateur/profil
 * 
 * @method Array getUserPermissionOnObject(integer $id) 
 * @return Array
 * getUserPermissionOnObject([0-9]+)
 * /api/v002/sso/utilisateur/autorisation/objet-touristique/modification/{id}
 * 
 * @method Array ssoUtilisateurAutorisationObjetTouristiqueModification(integer $id) 
 * @return Array
 * ssoUtilisateurAutorisationObjetTouristiqueModification([0-9]+)
 * /api/v002/sso/utilisateur/autorisation/objet-touristique/modification/{id}
 *  */
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

    /* Auth for metadata */
    'metaClientId' => null,
    'metaSecret'   => null,

    /* Auth for touristic offer edit */
    'editClientId' => null,
    'editSecret'   => null,

    /* Export */
    'exportDir'     => '/tmp/exports/',

    /* For HTTP Client */
    'timeout'           => 0,
    'connectTimeout'    => 0,
    'proxy'             => null,
    'verify'            => true,

    /* For SSO authentication */
    'ssoBaseUrl'        => 'https://base.apidae-tourisme.com',
    'ssoRedirectUrl'    => 'http://localhost/',
    'ssoClientId'       => null,
    'ssoSecret'         => null,

    /* Access tokens by scope */
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
