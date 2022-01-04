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

 * @method array searchAgenda(array $query) 
 * @return array
 * searchAgenda(['selectionIds' => [64, 5896,..],..],..])
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002agendasimplelist-objets-touristiques
 * /api/v002/agenda/simple/list-objets-touristiques

 * @method array agendaSimpleListObjetsTouristiques(array $query) 
 * @return array
 * agendaSimpleListObjetsTouristiques(['selectionIds' => [64, 5896,..],..],..])
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002agendasimplelist-objets-touristiques
 * /api/v002/agenda/simple/list-objets-touristiques

 * @method array searchAgendaIdentifier(array $query) 
 * @return array
 * searchAgendaIdentifier(['selectionIds' => [64, 5896,..],..],..])
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002agendasimplelist-identifiants
 * /api/v002/agenda/simple/list-identifiants

 * @method array agendaSimpleListIdentifiants(array $query) 
 * @return array
 * agendaSimpleListIdentifiants(['selectionIds' => [64, 5896,..],..],..])
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002agendasimplelist-identifiants
 * /api/v002/agenda/simple/list-identifiants

 * @method array searchDetailedAgenda(array $query) 
 * @return array
 * searchDetailedAgenda(['selectionIds' => [64, 5896,..],..],..])
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002agendadetaillelist-objets-touristiques
 * /api/v002/agenda/detaille/list-objets-touristiques

 * @method array agendaDetailleListObjetsTouristiques(array $query) 
 * @return array
 * agendaDetailleListObjetsTouristiques(['selectionIds' => [64, 5896,..],..],..])
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002agendadetaillelist-objets-touristiques
 * /api/v002/agenda/detaille/list-objets-touristiques

 * @method array searchDetailedAgendaIdentifier(array $query) 
 * @return array
 * searchDetailedAgendaIdentifier(['selectionIds' => [64, 5896,..],..],..])
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002agendadetaillelist-identifiants
 * /api/v002/agenda/detaille/list-identifiants

 * @method array agendaDetailleListIdentifiants(array $query) 
 * @return array
 * agendaDetailleListIdentifiants(['selectionIds' => [64, 5896,..],..],..])
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002agendadetaillelist-identifiants
 * /api/v002/agenda/detaille/list-identifiants

 * @method string getEditAutorisation(integer $id, string $tokenSSO) 
 * @return string
 * getEditAutorisation([0-9]+, ?'...')
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-decriture/v002autorisationobjet-touristiquemodification
 * /api/v002/autorisation/objet-touristique/modification/{id}

 * @method string autorisationObjetTouristiqueModification(integer $id, string $tokenSSO) 
 * @return string
 * autorisationObjetTouristiqueModification([0-9]+, ?'...')
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-decriture/v002autorisationobjet-touristiquemodification
 * /api/v002/autorisation/objet-touristique/modification/{id}

 * @method array confirmExport(string $hash) 
 * @return array
 * confirmExport('...')
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/exports/notificationi-traitement-confirmation
 * /api/v002/export/confirmation

 * @method array exportConfirmation(string $hash) 
 * @return array
 * exportConfirmation('...')
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/exports/notificationi-traitement-confirmation
 * /api/v002/export/confirmation

 * @method array getMemberById(integer $id, string $apiKey, string $projetId) 
 * @return array
 * getMemberById([0-9]+)
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002membreget-by-id-2
 * /api/v002/membre/get-by-id/{id}

 * @method array membreGetById(integer $id, string $apiKey, string $projetId) 
 * @return array
 * membreGetById([0-9]+)
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002membreget-by-id-2
 * /api/v002/membre/get-by-id/{id}

 * @method array getMembers(array $query) 
 * @return array
 * getMembers(['selectionIds' => [64, 5896,..],..],..])
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002membreget-membres
 * /api/v002/membre/get-membres

 * @method array membreGetMembres(array $query) 
 * @return array
 * membreGetMembres(['selectionIds' => [64, 5896,..],..],..])
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002membreget-membres
 * /api/v002/membre/get-membres

 * @method array getUserById(integer $id, string $apiKey, string $projetId) 
 * @return array
 * getUserById([0-9]+)
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002utilisateurget-by-id
 * /api/v002/utilisateur/get-by-id/{id}

 * @method array utilisateurGetById(integer $id, string $apiKey, string $projetId) 
 * @return array
 * utilisateurGetById([0-9]+)
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002utilisateurget-by-id
 * /api/v002/utilisateur/get-by-id/{id}

 * @method array getUserByMail(string $eMail, string $apiKey, string $projetId) 
 * @return array
 * getUserByMail('test@test.com')
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002utilisateurget-by-mail
 * /api/v002/utilisateur/get-by-mail/{eMail}

 * @method array utilisateurGetByMail(string $eMail, string $apiKey, string $projetId) 
 * @return array
 * utilisateurGetByMail('test@test.com')
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002utilisateurget-by-mail
 * /api/v002/utilisateur/get-by-mail/{eMail}

 * @method array getUsersByMember(integer $membre_id, string $apiKey, string $projetId) 
 * @return array
 * getUsersByMember([0-9]+)
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002utilisateurget-by-membre
 * /api/v002/utilisateur/get-by-membre/{membre_id}

 * @method array utilisateurGetByMembre(integer $membre_id, string $apiKey, string $projetId) 
 * @return array
 * utilisateurGetByMembre([0-9]+)
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002utilisateurget-by-membre
 * /api/v002/utilisateur/get-by-membre/{membre_id}

 * @method array getMetadata(integer $referenceId, string $nodeId, string $targetType, integer $targetId) 
 * @return array
 * getMetadata([0-9]+, '...', ?'general|membre|projet', ?[0-9]+)
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/metadonnees/web-service
 * /api/v002/metadata/{referenceId}/{nodeId}{/targetType}{/targetId}

 * @method array deleteMetadata(integer $referenceId, string $nodeId, string $targetType, integer $targetId) 
 * @return array
 * deleteMetadata([0-9]+, '...', ?'general|membre|projet', ?[0-9]+)
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/metadonnees/web-service
 * /api/v002/metadata/{referenceId}/{nodeId}{/targetType}{/targetId}

 * @method array putMetadata(integer $referenceId, string $nodeId, string $general, string $membres, string $projets, string $node) 
 * @return array
 * putMetadata([0-9]+, '...', ?'...', ?'...', ?'...', ?'...')
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/metadonnees/web-service
 * /api/v002/metadata/{referenceId}/{nodeId}

 * @method array getReferenceCity(array $query) 
 * @return array
 * getReferenceCity(['selectionIds' => [64, 5896,..],..],..])
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielcommunes
 * /api/v002/referentiel/communes

 * @method array referentielCommunes(array $query) 
 * @return array
 * referentielCommunes(['selectionIds' => [64, 5896,..],..],..])
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielcommunes
 * /api/v002/referentiel/communes

 * @method array getReferenceElement(array $query) 
 * @return array
 * getReferenceElement(['selectionIds' => [64, 5896,..],..],..])
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielelements-reference
 * /api/v002/referentiel/elements-reference

 * @method array referentielElementsReference(array $query) 
 * @return array
 * referentielElementsReference(['selectionIds' => [64, 5896,..],..],..])
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielelements-reference
 * /api/v002/referentiel/elements-reference

 * @method array getReferenceInternalCriteria(array $query) 
 * @return array
 * getReferenceInternalCriteria(['selectionIds' => [64, 5896,..],..],..])
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielcriteres-internes
 * /api/v002/referentiel/criteres-internes

 * @method array referentielCriteresInternes(array $query) 
 * @return array
 * referentielCriteresInternes(['selectionIds' => [64, 5896,..],..],..])
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielcriteres-internes
 * /api/v002/referentiel/criteres-internes

 * @method array getReferenceSelection(array $query) 
 * @return array
 * getReferenceSelection(['selectionIds' => [64, 5896,..],..],..])
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielselections
 * /api/v002/referentiel/selections

 * @method array referentielSelections(array $query) 
 * @return array
 * referentielSelections(['selectionIds' => [64, 5896,..],..],..])
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielselections
 * /api/v002/referentiel/selections

 * @method array getReferenceSelectionsByObject(array $query) 
 * @return array
 * getReferenceSelectionsByObject(['selectionIds' => [64, 5896,..],..],..])
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielselections-par-objet
 * /api/v002/referentiel/selections-par-objet

 * @method array referentielSelectionsParObjet(array $query) 
 * @return array
 * referentielSelectionsParObjet(['selectionIds' => [64, 5896,..],..],..])
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielselections-par-objet
 * /api/v002/referentiel/selections-par-objet

 * @method array searchObject(array $query) 
 * @return array
 * searchObject(['selectionIds' => [64, 5896,..],..],..])
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002recherchelist-objets-touristiques
 * /api/v002/recherche/list-objets-touristiques

 * @method array rechercheListObjetsTouristiques(array $query) 
 * @return array
 * rechercheListObjetsTouristiques(['selectionIds' => [64, 5896,..],..],..])
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002recherchelist-objets-touristiques
 * /api/v002/recherche/list-objets-touristiques

 * @method array searchObjectIdentifier(array $query) 
 * @return array
 * searchObjectIdentifier(['selectionIds' => [64, 5896,..],..],..])
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002recherchelist-identifiants
 * /api/v002/recherche/list-identifiants

 * @method array rechercheListIdentifiants(array $query) 
 * @return array
 * rechercheListIdentifiants(['selectionIds' => [64, 5896,..],..],..])
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002recherchelist-identifiants
 * /api/v002/recherche/list-identifiants

 * @method array getSsoToken(string $grant_type, string $code, string $redirect_uri) 
 * @return array
 * getSsoToken('authorization_code|client_credentials|refresh_token', '...', 'https://myapp.com/..')
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/oauth/single-sign-on
 * /oauth/token

 * @method array oauthToken(string $grant_type, string $code, string $redirect_uri) 
 * @return array
 * oauthToken('authorization_code|client_credentials|refresh_token', '...', 'https://myapp.com/..')
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/oauth/single-sign-on
 * /oauth/token

 * @method array refreshSsoToken(string $grant_type, string $refresh_token, string $redirect_uri) 
 * @return array
 * refreshSsoToken('authorization_code|client_credentials|refresh_token', '...', 'https://myapp.com/..')
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/oauth/single-sign-on
 * /oauth/token

 * @method array getObjectById(integer $id, string $responseFields, string $locales, string $apiKey, string $projetId) 
 * @return array
 * getObjectById([0-9]+, ?'@all..', ?'fr,en..')
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002objet-touristiqueget-by-id
 * /api/v002/objet-touristique/get-by-id/{id}

 * @method array objetTouristiqueGetById(integer $id, string $responseFields, string $locales, string $apiKey, string $projetId) 
 * @return array
 * objetTouristiqueGetById([0-9]+, ?'@all..', ?'fr,en..')
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002objet-touristiqueget-by-id
 * /api/v002/objet-touristique/get-by-id/{id}

 * @method array getObjectByIdentifier(string $identifier, string $responseFields, string $locales, string $apiKey, string $projetId) 
 * @return array
 * getObjectByIdentifier('sitra1234..', ?'@all..', ?'fr,en..')
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002objet-touristiqueget-by-identifier
 * /api/v002/objet-touristique/get-by-identifier/{identifier}

 * @method array objetTouristiqueGetByIdentifier(string $identifier, string $responseFields, string $locales, string $apiKey, string $projetId) 
 * @return array
 * objetTouristiqueGetByIdentifier('sitra1234..', ?'@all..', ?'fr,en..')
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002objet-touristiqueget-by-identifier
 * /api/v002/objet-touristique/get-by-identifier/{identifier}

 * @method array getUserProfile() 
 * @return array
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/oauth/services-associes-au-sso/v002ssoutilisateurprofil
 * /api/v002/sso/utilisateur/profil

 * @method array ssoUtilisateurProfil() 
 * @return array
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/oauth/services-associes-au-sso/v002ssoutilisateurprofil
 * /api/v002/sso/utilisateur/profil

 * @method string getUserPermissionOnObject(integer $id) 
 * @return string
 * getUserPermissionOnObject([0-9]+)
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/oauth/services-associes-au-sso/v002ssoutilisateurautorisationobjet-touristiquemodification
 * /api/v002/sso/utilisateur/autorisation/objet-touristique/modification/{id}

 * @method string ssoUtilisateurAutorisationObjetTouristiqueModification(integer $id) 
 * @return string
 * ssoUtilisateurAutorisationObjetTouristiqueModification([0-9]+)
 * https://dev.apidae-tourisme.com/fr/documentation-technique/v2/oauth/services-associes-au-sso/v002ssoutilisateurautorisationobjet-touristiquemodification
 * /api/v002/sso/utilisateur/autorisation/objet-touristique/modification/{id}
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

  public function __call($method, array $args)
  {
    $commandName = $method;
    /** @var GuzzleHttp\Command\Result $result */
    $result = parent::__call($commandName, $args);

    /** Traitement des retours en string au lieu de json */
    if (isset($result['stream'])) {
      $content = $result['stream']->getContents();
      if (is_string($content) && preg_match('#^"(.*)"$#', $content, $match))
        return $match[1];
    }

    return $result;
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
