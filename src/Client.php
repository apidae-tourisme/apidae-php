<?php

namespace ApidaePHP;

use ApidaePHP\Traits\Export;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use ApidaePHP\Description\Sso;
use GuzzleHttp\Command\Result;
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
use GuzzleHttp\Command\Guzzle\Operation;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Command\Guzzle\Description;
use ApidaePHP\Description\TouristicObjects;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use GuzzleHttp\Command\Exception\CommandException;
use ApidaePHP\Exception\InvalidMetadataFormatException;
use GuzzleHttp\Command\Exception\CommandClientException;
use GuzzleHttp\Command\Exception\CommandServerException;

/** Magic Methods Doc */
/** 

 *	@method array searchAgenda(array $parameters) 
 *	@param array{query: array} $parameters {
 *		@type array $query {
 *				@type array $identifiants [0,1,2...]
 *				@type array $identifiers ['abc','def',...]
 *				@type integer $listeEnregistreeId 1234
 *				@type array $selectionIds [0,1,2...]
 *				@type object $center ['type' => 'Point', 'coordinates' => [4.8 (lon), 45.3 (lat)]]
 *				@type integer $radius 1234
 *				@type array $communeCodesInsee ['abc','def',...]
 *				@type array $territoireIds [0,1,2...]
 *				@type string $searchQuery 'abcd...'
 *				@type string $searchFields 'NOM|NOM_DESCRIPTION|NOM_DESCRIPTION_CRITERES'
 *				@type string $criteresQuery 'abcd...'
 *				@type string $dateDebut '2022-01-07'
 *				@type string $dateFin '2022-01-07'
 *				@type integer $first 1234
 *				@type integer $count 1234
 *				@type string $order 'PERTINENCE|NOM|DISTANCE|IDENTIFIANT|DATE_OUVERTURE|RANDOM'
 *				@type boolean $asc 
 *				@type array $locales ['abc','def',...]
 *				@type array $responseFields ['@all','informations.moyensCommunication','...']
 *				@type string $apiKey 'abcd...'
 *				@type integer $projetId 1234
 *				@type string $randomSeed 'abcd...'
 *				@type array $membreProprietaireIds [0,1,2...]
 *				@type string $searchLocale 'abcd...'
 *			}
 *	}
 *	@example $client->searchAgenda([
 *		'query' => [
 *				'identifiants' => [0,1,2...],
 *				'identifiers' => ['abc','def',...],
 *				'listeEnregistreeId' => 1234,
 *				'selectionIds' => [0,1,2...],
 *				'center' => ['type' => 'Point', 'coordinates' => [4.8 (lon), 45.3 (lat)]],
 *				'radius' => 1234,
 *				'communeCodesInsee' => ['abc','def',...],
 *				'territoireIds' => [0,1,2...],
 *				'searchQuery' => 'abcd...',
 *				'searchFields' => 'NOM|NOM_DESCRIPTION|NOM_DESCRIPTION_CRITERES',
 *				'criteresQuery' => 'abcd...',
 *				'dateDebut' => '2022-01-07',
 *				'dateFin' => '2022-01-07',
 *				'first' => 1234,
 *				'count' => 1234,
 *				'order' => 'PERTINENCE|NOM|DISTANCE|IDENTIFIANT|DATE_OUVERTURE|RANDOM',
 *				'asc' => ,
 *				'locales' => ['abc','def',...],
 *				'responseFields' => ['@all','informations.moyensCommunication','...'],
 *				'apiKey' => 'abcd...',
 *				'projetId' => 1234,
 *				'randomSeed' => 'abcd...',
 *				'membreProprietaireIds' => [0,1,2...],
 *				'searchLocale' => 'abcd...'
 *			]
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002agendasimplelist-objets-touristiques
 *	
 *	/api/v002/agenda/simple/list-objets-touristiques

 *	@method array agendaSimpleListObjetsTouristiques(array $parameters) 
 *	@param array{query: array} $parameters {
 *		@type array $query {
 *				@type array $identifiants [0,1,2...]
 *				@type array $identifiers ['abc','def',...]
 *				@type integer $listeEnregistreeId 1234
 *				@type array $selectionIds [0,1,2...]
 *				@type object $center ['type' => 'Point', 'coordinates' => [4.8 (lon), 45.3 (lat)]]
 *				@type integer $radius 1234
 *				@type array $communeCodesInsee ['abc','def',...]
 *				@type array $territoireIds [0,1,2...]
 *				@type string $searchQuery 'abcd...'
 *				@type string $searchFields 'NOM|NOM_DESCRIPTION|NOM_DESCRIPTION_CRITERES'
 *				@type string $criteresQuery 'abcd...'
 *				@type string $dateDebut '2022-01-07'
 *				@type string $dateFin '2022-01-07'
 *				@type integer $first 1234
 *				@type integer $count 1234
 *				@type string $order 'PERTINENCE|NOM|DISTANCE|IDENTIFIANT|DATE_OUVERTURE|RANDOM'
 *				@type boolean $asc 
 *				@type array $locales ['abc','def',...]
 *				@type array $responseFields ['@all','informations.moyensCommunication','...']
 *				@type string $apiKey 'abcd...'
 *				@type integer $projetId 1234
 *				@type string $randomSeed 'abcd...'
 *				@type array $membreProprietaireIds [0,1,2...]
 *				@type string $searchLocale 'abcd...'
 *			}
 *	}
 *	@example $client->agendaSimpleListObjetsTouristiques([
 *		'query' => [
 *				'identifiants' => [0,1,2...],
 *				'identifiers' => ['abc','def',...],
 *				'listeEnregistreeId' => 1234,
 *				'selectionIds' => [0,1,2...],
 *				'center' => ['type' => 'Point', 'coordinates' => [4.8 (lon), 45.3 (lat)]],
 *				'radius' => 1234,
 *				'communeCodesInsee' => ['abc','def',...],
 *				'territoireIds' => [0,1,2...],
 *				'searchQuery' => 'abcd...',
 *				'searchFields' => 'NOM|NOM_DESCRIPTION|NOM_DESCRIPTION_CRITERES',
 *				'criteresQuery' => 'abcd...',
 *				'dateDebut' => '2022-01-07',
 *				'dateFin' => '2022-01-07',
 *				'first' => 1234,
 *				'count' => 1234,
 *				'order' => 'PERTINENCE|NOM|DISTANCE|IDENTIFIANT|DATE_OUVERTURE|RANDOM',
 *				'asc' => ,
 *				'locales' => ['abc','def',...],
 *				'responseFields' => ['@all','informations.moyensCommunication','...'],
 *				'apiKey' => 'abcd...',
 *				'projetId' => 1234,
 *				'randomSeed' => 'abcd...',
 *				'membreProprietaireIds' => [0,1,2...],
 *				'searchLocale' => 'abcd...'
 *			]
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002agendasimplelist-objets-touristiques
 *	
 *	/api/v002/agenda/simple/list-objets-touristiques

 *	@method array searchAgendaIdentifier(array $parameters) 
 *	@param array{query: array} $parameters {
 *		@type array $query {
 *				@type array $identifiants [0,1,2...]
 *				@type array $identifiers ['abc','def',...]
 *				@type integer $listeEnregistreeId 1234
 *				@type array $selectionIds [0,1,2...]
 *				@type object $center ['type' => 'Point', 'coordinates' => [4.8 (lon), 45.3 (lat)]]
 *				@type integer $radius 1234
 *				@type array $communeCodesInsee ['abc','def',...]
 *				@type array $territoireIds [0,1,2...]
 *				@type string $searchQuery 'abcd...'
 *				@type string $searchFields 'NOM|NOM_DESCRIPTION|NOM_DESCRIPTION_CRITERES'
 *				@type string $criteresQuery 'abcd...'
 *				@type string $dateDebut '2022-01-07'
 *				@type string $dateFin '2022-01-07'
 *				@type integer $first 1234
 *				@type integer $count 1234
 *				@type string $order 'PERTINENCE|NOM|DISTANCE|IDENTIFIANT|DATE_OUVERTURE|RANDOM'
 *				@type boolean $asc 
 *				@type array $locales ['abc','def',...]
 *				@type array $responseFields ['@all','informations.moyensCommunication','...']
 *				@type string $apiKey 'abcd...'
 *				@type integer $projetId 1234
 *				@type string $randomSeed 'abcd...'
 *				@type array $membreProprietaireIds [0,1,2...]
 *				@type string $searchLocale 'abcd...'
 *			}
 *	}
 *	@example $client->searchAgendaIdentifier([
 *		'query' => [
 *				'identifiants' => [0,1,2...],
 *				'identifiers' => ['abc','def',...],
 *				'listeEnregistreeId' => 1234,
 *				'selectionIds' => [0,1,2...],
 *				'center' => ['type' => 'Point', 'coordinates' => [4.8 (lon), 45.3 (lat)]],
 *				'radius' => 1234,
 *				'communeCodesInsee' => ['abc','def',...],
 *				'territoireIds' => [0,1,2...],
 *				'searchQuery' => 'abcd...',
 *				'searchFields' => 'NOM|NOM_DESCRIPTION|NOM_DESCRIPTION_CRITERES',
 *				'criteresQuery' => 'abcd...',
 *				'dateDebut' => '2022-01-07',
 *				'dateFin' => '2022-01-07',
 *				'first' => 1234,
 *				'count' => 1234,
 *				'order' => 'PERTINENCE|NOM|DISTANCE|IDENTIFIANT|DATE_OUVERTURE|RANDOM',
 *				'asc' => ,
 *				'locales' => ['abc','def',...],
 *				'responseFields' => ['@all','informations.moyensCommunication','...'],
 *				'apiKey' => 'abcd...',
 *				'projetId' => 1234,
 *				'randomSeed' => 'abcd...',
 *				'membreProprietaireIds' => [0,1,2...],
 *				'searchLocale' => 'abcd...'
 *			]
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002agendasimplelist-identifiants
 *	
 *	/api/v002/agenda/simple/list-identifiants

 *	@method array agendaSimpleListIdentifiants(array $parameters) 
 *	@param array{query: array} $parameters {
 *		@type array $query {
 *				@type array $identifiants [0,1,2...]
 *				@type array $identifiers ['abc','def',...]
 *				@type integer $listeEnregistreeId 1234
 *				@type array $selectionIds [0,1,2...]
 *				@type object $center ['type' => 'Point', 'coordinates' => [4.8 (lon), 45.3 (lat)]]
 *				@type integer $radius 1234
 *				@type array $communeCodesInsee ['abc','def',...]
 *				@type array $territoireIds [0,1,2...]
 *				@type string $searchQuery 'abcd...'
 *				@type string $searchFields 'NOM|NOM_DESCRIPTION|NOM_DESCRIPTION_CRITERES'
 *				@type string $criteresQuery 'abcd...'
 *				@type string $dateDebut '2022-01-07'
 *				@type string $dateFin '2022-01-07'
 *				@type integer $first 1234
 *				@type integer $count 1234
 *				@type string $order 'PERTINENCE|NOM|DISTANCE|IDENTIFIANT|DATE_OUVERTURE|RANDOM'
 *				@type boolean $asc 
 *				@type array $locales ['abc','def',...]
 *				@type array $responseFields ['@all','informations.moyensCommunication','...']
 *				@type string $apiKey 'abcd...'
 *				@type integer $projetId 1234
 *				@type string $randomSeed 'abcd...'
 *				@type array $membreProprietaireIds [0,1,2...]
 *				@type string $searchLocale 'abcd...'
 *			}
 *	}
 *	@example $client->agendaSimpleListIdentifiants([
 *		'query' => [
 *				'identifiants' => [0,1,2...],
 *				'identifiers' => ['abc','def',...],
 *				'listeEnregistreeId' => 1234,
 *				'selectionIds' => [0,1,2...],
 *				'center' => ['type' => 'Point', 'coordinates' => [4.8 (lon), 45.3 (lat)]],
 *				'radius' => 1234,
 *				'communeCodesInsee' => ['abc','def',...],
 *				'territoireIds' => [0,1,2...],
 *				'searchQuery' => 'abcd...',
 *				'searchFields' => 'NOM|NOM_DESCRIPTION|NOM_DESCRIPTION_CRITERES',
 *				'criteresQuery' => 'abcd...',
 *				'dateDebut' => '2022-01-07',
 *				'dateFin' => '2022-01-07',
 *				'first' => 1234,
 *				'count' => 1234,
 *				'order' => 'PERTINENCE|NOM|DISTANCE|IDENTIFIANT|DATE_OUVERTURE|RANDOM',
 *				'asc' => ,
 *				'locales' => ['abc','def',...],
 *				'responseFields' => ['@all','informations.moyensCommunication','...'],
 *				'apiKey' => 'abcd...',
 *				'projetId' => 1234,
 *				'randomSeed' => 'abcd...',
 *				'membreProprietaireIds' => [0,1,2...],
 *				'searchLocale' => 'abcd...'
 *			]
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002agendasimplelist-identifiants
 *	
 *	/api/v002/agenda/simple/list-identifiants

 *	@method array searchDetailedAgenda(array $parameters) 
 *	@param array{query: array} $parameters {
 *		@type array $query {
 *				@type array $identifiants [0,1,2...]
 *				@type array $identifiers ['abc','def',...]
 *				@type integer $listeEnregistreeId 1234
 *				@type array $selectionIds [0,1,2...]
 *				@type object $center ['type' => 'Point', 'coordinates' => [4.8 (lon), 45.3 (lat)]]
 *				@type integer $radius 1234
 *				@type array $communeCodesInsee ['abc','def',...]
 *				@type array $territoireIds [0,1,2...]
 *				@type string $searchQuery 'abcd...'
 *				@type string $searchFields 'NOM|NOM_DESCRIPTION|NOM_DESCRIPTION_CRITERES'
 *				@type string $criteresQuery 'abcd...'
 *				@type string $dateDebut '2022-01-07'
 *				@type string $dateFin '2022-01-07'
 *				@type integer $first 1234
 *				@type integer $count 1234
 *				@type string $order 'PERTINENCE|NOM|DISTANCE|IDENTIFIANT|DATE_OUVERTURE|RANDOM'
 *				@type boolean $asc 
 *				@type array $locales ['abc','def',...]
 *				@type array $responseFields ['@all','informations.moyensCommunication','...']
 *				@type string $apiKey 'abcd...'
 *				@type integer $projetId 1234
 *				@type string $randomSeed 'abcd...'
 *				@type array $membreProprietaireIds [0,1,2...]
 *				@type string $searchLocale 'abcd...'
 *			}
 *	}
 *	@example $client->searchDetailedAgenda([
 *		'query' => [
 *				'identifiants' => [0,1,2...],
 *				'identifiers' => ['abc','def',...],
 *				'listeEnregistreeId' => 1234,
 *				'selectionIds' => [0,1,2...],
 *				'center' => ['type' => 'Point', 'coordinates' => [4.8 (lon), 45.3 (lat)]],
 *				'radius' => 1234,
 *				'communeCodesInsee' => ['abc','def',...],
 *				'territoireIds' => [0,1,2...],
 *				'searchQuery' => 'abcd...',
 *				'searchFields' => 'NOM|NOM_DESCRIPTION|NOM_DESCRIPTION_CRITERES',
 *				'criteresQuery' => 'abcd...',
 *				'dateDebut' => '2022-01-07',
 *				'dateFin' => '2022-01-07',
 *				'first' => 1234,
 *				'count' => 1234,
 *				'order' => 'PERTINENCE|NOM|DISTANCE|IDENTIFIANT|DATE_OUVERTURE|RANDOM',
 *				'asc' => ,
 *				'locales' => ['abc','def',...],
 *				'responseFields' => ['@all','informations.moyensCommunication','...'],
 *				'apiKey' => 'abcd...',
 *				'projetId' => 1234,
 *				'randomSeed' => 'abcd...',
 *				'membreProprietaireIds' => [0,1,2...],
 *				'searchLocale' => 'abcd...'
 *			]
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002agendadetaillelist-objets-touristiques
 *	
 *	/api/v002/agenda/detaille/list-objets-touristiques

 *	@method array agendaDetailleListObjetsTouristiques(array $parameters) 
 *	@param array{query: array} $parameters {
 *		@type array $query {
 *				@type array $identifiants [0,1,2...]
 *				@type array $identifiers ['abc','def',...]
 *				@type integer $listeEnregistreeId 1234
 *				@type array $selectionIds [0,1,2...]
 *				@type object $center ['type' => 'Point', 'coordinates' => [4.8 (lon), 45.3 (lat)]]
 *				@type integer $radius 1234
 *				@type array $communeCodesInsee ['abc','def',...]
 *				@type array $territoireIds [0,1,2...]
 *				@type string $searchQuery 'abcd...'
 *				@type string $searchFields 'NOM|NOM_DESCRIPTION|NOM_DESCRIPTION_CRITERES'
 *				@type string $criteresQuery 'abcd...'
 *				@type string $dateDebut '2022-01-07'
 *				@type string $dateFin '2022-01-07'
 *				@type integer $first 1234
 *				@type integer $count 1234
 *				@type string $order 'PERTINENCE|NOM|DISTANCE|IDENTIFIANT|DATE_OUVERTURE|RANDOM'
 *				@type boolean $asc 
 *				@type array $locales ['abc','def',...]
 *				@type array $responseFields ['@all','informations.moyensCommunication','...']
 *				@type string $apiKey 'abcd...'
 *				@type integer $projetId 1234
 *				@type string $randomSeed 'abcd...'
 *				@type array $membreProprietaireIds [0,1,2...]
 *				@type string $searchLocale 'abcd...'
 *			}
 *	}
 *	@example $client->agendaDetailleListObjetsTouristiques([
 *		'query' => [
 *				'identifiants' => [0,1,2...],
 *				'identifiers' => ['abc','def',...],
 *				'listeEnregistreeId' => 1234,
 *				'selectionIds' => [0,1,2...],
 *				'center' => ['type' => 'Point', 'coordinates' => [4.8 (lon), 45.3 (lat)]],
 *				'radius' => 1234,
 *				'communeCodesInsee' => ['abc','def',...],
 *				'territoireIds' => [0,1,2...],
 *				'searchQuery' => 'abcd...',
 *				'searchFields' => 'NOM|NOM_DESCRIPTION|NOM_DESCRIPTION_CRITERES',
 *				'criteresQuery' => 'abcd...',
 *				'dateDebut' => '2022-01-07',
 *				'dateFin' => '2022-01-07',
 *				'first' => 1234,
 *				'count' => 1234,
 *				'order' => 'PERTINENCE|NOM|DISTANCE|IDENTIFIANT|DATE_OUVERTURE|RANDOM',
 *				'asc' => ,
 *				'locales' => ['abc','def',...],
 *				'responseFields' => ['@all','informations.moyensCommunication','...'],
 *				'apiKey' => 'abcd...',
 *				'projetId' => 1234,
 *				'randomSeed' => 'abcd...',
 *				'membreProprietaireIds' => [0,1,2...],
 *				'searchLocale' => 'abcd...'
 *			]
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002agendadetaillelist-objets-touristiques
 *	
 *	/api/v002/agenda/detaille/list-objets-touristiques

 *	@method array searchDetailedAgendaIdentifier(array $parameters) 
 *	@param array{query: array} $parameters {
 *		@type array $query {
 *				@type array $identifiants [0,1,2...]
 *				@type array $identifiers ['abc','def',...]
 *				@type integer $listeEnregistreeId 1234
 *				@type array $selectionIds [0,1,2...]
 *				@type object $center ['type' => 'Point', 'coordinates' => [4.8 (lon), 45.3 (lat)]]
 *				@type integer $radius 1234
 *				@type array $communeCodesInsee ['abc','def',...]
 *				@type array $territoireIds [0,1,2...]
 *				@type string $searchQuery 'abcd...'
 *				@type string $searchFields 'NOM|NOM_DESCRIPTION|NOM_DESCRIPTION_CRITERES'
 *				@type string $criteresQuery 'abcd...'
 *				@type string $dateDebut '2022-01-07'
 *				@type string $dateFin '2022-01-07'
 *				@type integer $first 1234
 *				@type integer $count 1234
 *				@type string $order 'PERTINENCE|NOM|DISTANCE|IDENTIFIANT|DATE_OUVERTURE|RANDOM'
 *				@type boolean $asc 
 *				@type array $locales ['abc','def',...]
 *				@type array $responseFields ['@all','informations.moyensCommunication','...']
 *				@type string $apiKey 'abcd...'
 *				@type integer $projetId 1234
 *				@type string $randomSeed 'abcd...'
 *				@type array $membreProprietaireIds [0,1,2...]
 *				@type string $searchLocale 'abcd...'
 *			}
 *	}
 *	@example $client->searchDetailedAgendaIdentifier([
 *		'query' => [
 *				'identifiants' => [0,1,2...],
 *				'identifiers' => ['abc','def',...],
 *				'listeEnregistreeId' => 1234,
 *				'selectionIds' => [0,1,2...],
 *				'center' => ['type' => 'Point', 'coordinates' => [4.8 (lon), 45.3 (lat)]],
 *				'radius' => 1234,
 *				'communeCodesInsee' => ['abc','def',...],
 *				'territoireIds' => [0,1,2...],
 *				'searchQuery' => 'abcd...',
 *				'searchFields' => 'NOM|NOM_DESCRIPTION|NOM_DESCRIPTION_CRITERES',
 *				'criteresQuery' => 'abcd...',
 *				'dateDebut' => '2022-01-07',
 *				'dateFin' => '2022-01-07',
 *				'first' => 1234,
 *				'count' => 1234,
 *				'order' => 'PERTINENCE|NOM|DISTANCE|IDENTIFIANT|DATE_OUVERTURE|RANDOM',
 *				'asc' => ,
 *				'locales' => ['abc','def',...],
 *				'responseFields' => ['@all','informations.moyensCommunication','...'],
 *				'apiKey' => 'abcd...',
 *				'projetId' => 1234,
 *				'randomSeed' => 'abcd...',
 *				'membreProprietaireIds' => [0,1,2...],
 *				'searchLocale' => 'abcd...'
 *			]
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002agendadetaillelist-identifiants
 *	
 *	/api/v002/agenda/detaille/list-identifiants

 *	@method array agendaDetailleListIdentifiants(array $parameters) 
 *	@param array{query: array} $parameters {
 *		@type array $query {
 *				@type array $identifiants [0,1,2...]
 *				@type array $identifiers ['abc','def',...]
 *				@type integer $listeEnregistreeId 1234
 *				@type array $selectionIds [0,1,2...]
 *				@type object $center ['type' => 'Point', 'coordinates' => [4.8 (lon), 45.3 (lat)]]
 *				@type integer $radius 1234
 *				@type array $communeCodesInsee ['abc','def',...]
 *				@type array $territoireIds [0,1,2...]
 *				@type string $searchQuery 'abcd...'
 *				@type string $searchFields 'NOM|NOM_DESCRIPTION|NOM_DESCRIPTION_CRITERES'
 *				@type string $criteresQuery 'abcd...'
 *				@type string $dateDebut '2022-01-07'
 *				@type string $dateFin '2022-01-07'
 *				@type integer $first 1234
 *				@type integer $count 1234
 *				@type string $order 'PERTINENCE|NOM|DISTANCE|IDENTIFIANT|DATE_OUVERTURE|RANDOM'
 *				@type boolean $asc 
 *				@type array $locales ['abc','def',...]
 *				@type array $responseFields ['@all','informations.moyensCommunication','...']
 *				@type string $apiKey 'abcd...'
 *				@type integer $projetId 1234
 *				@type string $randomSeed 'abcd...'
 *				@type array $membreProprietaireIds [0,1,2...]
 *				@type string $searchLocale 'abcd...'
 *			}
 *	}
 *	@example $client->agendaDetailleListIdentifiants([
 *		'query' => [
 *				'identifiants' => [0,1,2...],
 *				'identifiers' => ['abc','def',...],
 *				'listeEnregistreeId' => 1234,
 *				'selectionIds' => [0,1,2...],
 *				'center' => ['type' => 'Point', 'coordinates' => [4.8 (lon), 45.3 (lat)]],
 *				'radius' => 1234,
 *				'communeCodesInsee' => ['abc','def',...],
 *				'territoireIds' => [0,1,2...],
 *				'searchQuery' => 'abcd...',
 *				'searchFields' => 'NOM|NOM_DESCRIPTION|NOM_DESCRIPTION_CRITERES',
 *				'criteresQuery' => 'abcd...',
 *				'dateDebut' => '2022-01-07',
 *				'dateFin' => '2022-01-07',
 *				'first' => 1234,
 *				'count' => 1234,
 *				'order' => 'PERTINENCE|NOM|DISTANCE|IDENTIFIANT|DATE_OUVERTURE|RANDOM',
 *				'asc' => ,
 *				'locales' => ['abc','def',...],
 *				'responseFields' => ['@all','informations.moyensCommunication','...'],
 *				'apiKey' => 'abcd...',
 *				'projetId' => 1234,
 *				'randomSeed' => 'abcd...',
 *				'membreProprietaireIds' => [0,1,2...],
 *				'searchLocale' => 'abcd...'
 *			]
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002agendadetaillelist-identifiants
 *	
 *	/api/v002/agenda/detaille/list-identifiants

 *	@method string getEditAutorisation(array $parameters) 
 *	@param array{id: integer, tokenSSO: string} $parameters {
 *		@type integer $id 
 *		@type string $tokenSSO 'abcd...'
 *	}
 *	@example $client->getEditAutorisation([
 *		'id' => , 
 *		'tokenSSO' => 'abcd...'
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-decriture/v002autorisationobjet-touristiquemodification
 *	
 *	/api/v002/autorisation/objet-touristique/modification/{id}

 *	@method string autorisationObjetTouristiqueModification(array $parameters) 
 *	@param array{id: integer, tokenSSO: string} $parameters {
 *		@type integer $id 
 *		@type string $tokenSSO 'abcd...'
 *	}
 *	@example $client->autorisationObjetTouristiqueModification([
 *		'id' => , 
 *		'tokenSSO' => 'abcd...'
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-decriture/v002autorisationobjet-touristiquemodification
 *	
 *	/api/v002/autorisation/objet-touristique/modification/{id}

 *	@method array confirmExport(array $parameters) 
 *	@param array{hash: string} $parameters {
 *		@type string $hash 'abcd...'
 *	}
 *	@example $client->confirmExport([
 *		'hash' => 'abcd...'
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/exports/notificationi-traitement-confirmation
 *	
 *	/api/v002/export/confirmation

 *	@method array exportConfirmation(array $parameters) 
 *	@param array{hash: string} $parameters {
 *		@type string $hash 'abcd...'
 *	}
 *	@example $client->exportConfirmation([
 *		'hash' => 'abcd...'
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/exports/notificationi-traitement-confirmation
 *	
 *	/api/v002/export/confirmation

 *	@method array getMemberById(array $parameters) 
 *	@param array{id: integer} $parameters {
 *		@type integer $id 
 *	}
 *	@example $client->getMemberById([
 *		'id' => 
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002membreget-by-id-2
 *	
 *	/api/v002/membre/get-by-id/{id}

 *	@method array membreGetById(array $parameters) 
 *	@param array{id: integer} $parameters {
 *		@type integer $id 
 *	}
 *	@example $client->membreGetById([
 *		'id' => 
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002membreget-by-id-2
 *	
 *	/api/v002/membre/get-by-id/{id}

 *	@method array getMembers(array $parameters) 
 *	@param array{query: array} $parameters {
 *		@type array $query {
 *				
 *			}
 *	}
 *	@example $client->getMembers([
 *		'query' => [
 *				'selectionsIds =>[1,2,3...] 
 *			]
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002membreget-membres
 *	
 *	/api/v002/membre/get-membres

 *	@method array membreGetMembres(array $parameters) 
 *	@param array{query: array} $parameters {
 *		@type array $query {
 *				
 *			}
 *	}
 *	@example $client->membreGetMembres([
 *		'query' => [
 *				'selectionsIds =>[1,2,3...] 
 *			]
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002membreget-membres
 *	
 *	/api/v002/membre/get-membres

 *	@method array getUserById(array $parameters) 
 *	@param array{id: integer} $parameters {
 *		@type integer $id 
 *	}
 *	@example $client->getUserById([
 *		'id' => 
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002utilisateurget-by-id
 *	
 *	/api/v002/utilisateur/get-by-id/{id}

 *	@method array utilisateurGetById(array $parameters) 
 *	@param array{id: integer} $parameters {
 *		@type integer $id 
 *	}
 *	@example $client->utilisateurGetById([
 *		'id' => 
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002utilisateurget-by-id
 *	
 *	/api/v002/utilisateur/get-by-id/{id}

 *	@method array getUserByMail(array $parameters) 
 *	@param array{eMail: string} $parameters {
 *		@type string $eMail user@gmail.com
 *	}
 *	@example $client->getUserByMail([
 *		'eMail' => user@gmail.com
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002utilisateurget-by-mail
 *	
 *	/api/v002/utilisateur/get-by-mail/{eMail}

 *	@method array utilisateurGetByMail(array $parameters) 
 *	@param array{eMail: string} $parameters {
 *		@type string $eMail user@gmail.com
 *	}
 *	@example $client->utilisateurGetByMail([
 *		'eMail' => user@gmail.com
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002utilisateurget-by-mail
 *	
 *	/api/v002/utilisateur/get-by-mail/{eMail}

 *	@method array getUsersByMember(array $parameters) 
 *	@param array{membre_id: integer} $parameters {
 *		@type integer $membre_id 
 *	}
 *	@example $client->getUsersByMember([
 *		'membre_id' => 
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002utilisateurget-by-membre
 *	
 *	/api/v002/utilisateur/get-by-membre/{membre_id}

 *	@method array utilisateurGetByMembre(array $parameters) 
 *	@param array{membre_id: integer} $parameters {
 *		@type integer $membre_id 
 *	}
 *	@example $client->utilisateurGetByMembre([
 *		'membre_id' => 
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002utilisateurget-by-membre
 *	
 *	/api/v002/utilisateur/get-by-membre/{membre_id}

 *	@method array getMetadata(array $parameters) 
 *	@param array{referenceId: integer, nodeId: string, targetType: string, targetId: integer} $parameters {
 *		@type integer $referenceId 
 *		@type string $nodeId 'abcd...'
 *		@type string $targetType 'abcd...'
 *		@type integer $targetId 
 *	}
 *	@example $client->getMetadata([
 *		'referenceId' => , 
 *		'nodeId' => 'abcd...', 
 *		'targetType' => 'abcd...' Available values : 'general|membre|projet', 
 *		'targetId' => 
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/metadonnees/web-service
 *	
 *	/api/v002/metadata/{referenceId}/{nodeId}{/targetType}{/targetId}

 *	@method array deleteMetadata(array $parameters) 
 *	@param array{referenceId: integer, nodeId: string, targetType: string, targetId: integer} $parameters {
 *		@type integer $referenceId 
 *		@type string $nodeId 'abcd...'
 *		@type string $targetType 'abcd...'
 *		@type integer $targetId 
 *	}
 *	@example $client->deleteMetadata([
 *		'referenceId' => , 
 *		'nodeId' => 'abcd...', 
 *		'targetType' => 'abcd...' Available values : 'general|membre|projet', 
 *		'targetId' => 
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/metadonnees/web-service
 *	
 *	/api/v002/metadata/{referenceId}/{nodeId}{/targetType}{/targetId}

 *	@method array putMetadata(array $parameters) 
 *	@param array{referenceId: integer, nodeId: string, general: string, membres: string, projets: string, node: string} $parameters {
 *		@type integer $referenceId 
 *		@type string $nodeId 'abcd...'
 *		@type string $general 'abcd...'
 *		@type string $membres 'abcd...'
 *		@type string $projets 'abcd...'
 *		@type string $node 'abcd...'
 *	}
 *	@example $client->putMetadata([
 *		'referenceId' => , 
 *		'nodeId' => 'abcd...' Values (examples) : 'tripadvisor|opensystem|...', 
 *		'general' => 'abcd...', 
 *		'membres' => 'abcd...', 
 *		'projets' => 'abcd...', 
 *		'node' => 'abcd...'
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/metadonnees/web-service
 *	
 *	/api/v002/metadata/{referenceId}/{nodeId}

 *	@method array getReferenceCity(array $parameters) 
 *	@param array{query: array} $parameters {
 *		@type array $query {
 *				@type string $apiKey 'abcd...'
 *				@type integer $projetId 1234
 *				@type array $communeIds [0,1,2...]
 *				@type array $codesInsee ['abc','def',...]
 *			}
 *	}
 *	@example $client->getReferenceCity([
 *		'query' => [
 *				'apiKey' => 'abcd...',
 *				'projetId' => 1234,
 *				'communeIds' => [0,1,2...],
 *				'codesInsee' => ['abc','def',...]
 *			]
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielcommunes
 *	
 *	/api/v002/referentiel/communes

 *	@method array referentielCommunes(array $parameters) 
 *	@param array{query: array} $parameters {
 *		@type array $query {
 *				@type string $apiKey 'abcd...'
 *				@type integer $projetId 1234
 *				@type array $communeIds [0,1,2...]
 *				@type array $codesInsee ['abc','def',...]
 *			}
 *	}
 *	@example $client->referentielCommunes([
 *		'query' => [
 *				'apiKey' => 'abcd...',
 *				'projetId' => 1234,
 *				'communeIds' => [0,1,2...],
 *				'codesInsee' => ['abc','def',...]
 *			]
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielcommunes
 *	
 *	/api/v002/referentiel/communes

 *	@method array getReferenceElement(array $parameters) 
 *	@param array{query: array} $parameters {
 *		@type array $query {
 *				@type string $apiKey 'abcd...'
 *				@type integer $projetId 1234
 *				@type array $elementReferenceIds [0,1,2...]
 *			}
 *	}
 *	@example $client->getReferenceElement([
 *		'query' => [
 *				'apiKey' => 'abcd...',
 *				'projetId' => 1234,
 *				'elementReferenceIds' => [0,1,2...]
 *			]
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielelements-reference
 *	
 *	/api/v002/referentiel/elements-reference

 *	@method array referentielElementsReference(array $parameters) 
 *	@param array{query: array} $parameters {
 *		@type array $query {
 *				@type string $apiKey 'abcd...'
 *				@type integer $projetId 1234
 *				@type array $elementReferenceIds [0,1,2...]
 *			}
 *	}
 *	@example $client->referentielElementsReference([
 *		'query' => [
 *				'apiKey' => 'abcd...',
 *				'projetId' => 1234,
 *				'elementReferenceIds' => [0,1,2...]
 *			]
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielelements-reference
 *	
 *	/api/v002/referentiel/elements-reference

 *	@method array getReferenceInternalCriteria(array $parameters) 
 *	@param array{query: array} $parameters {
 *		@type array $query {
 *				@type string $apiKey 'abcd...'
 *				@type integer $projetId 1234
 *				@type array $critereInterneIds [0,1,2...]
 *			}
 *	}
 *	@example $client->getReferenceInternalCriteria([
 *		'query' => [
 *				'apiKey' => 'abcd...',
 *				'projetId' => 1234,
 *				'critereInterneIds' => [0,1,2...]
 *			]
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielcriteres-internes
 *	
 *	/api/v002/referentiel/criteres-internes

 *	@method array referentielCriteresInternes(array $parameters) 
 *	@param array{query: array} $parameters {
 *		@type array $query {
 *				@type string $apiKey 'abcd...'
 *				@type integer $projetId 1234
 *				@type array $critereInterneIds [0,1,2...]
 *			}
 *	}
 *	@example $client->referentielCriteresInternes([
 *		'query' => [
 *				'apiKey' => 'abcd...',
 *				'projetId' => 1234,
 *				'critereInterneIds' => [0,1,2...]
 *			]
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielcriteres-internes
 *	
 *	/api/v002/referentiel/criteres-internes

 *	@method array getReferenceSelection(array $parameters) 
 *	@param array{query: array} $parameters {
 *		@type array $query {
 *				@type string $apiKey 'abcd...'
 *				@type integer $projetId 1234
 *				@type array $selectionIds [0,1,2...]
 *			}
 *	}
 *	@example $client->getReferenceSelection([
 *		'query' => [
 *				'apiKey' => 'abcd...',
 *				'projetId' => 1234,
 *				'selectionIds' => [0,1,2...]
 *			]
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielselections
 *	
 *	/api/v002/referentiel/selections

 *	@method array referentielSelections(array $parameters) 
 *	@param array{query: array} $parameters {
 *		@type array $query {
 *				@type string $apiKey 'abcd...'
 *				@type integer $projetId 1234
 *				@type array $selectionIds [0,1,2...]
 *			}
 *	}
 *	@example $client->referentielSelections([
 *		'query' => [
 *				'apiKey' => 'abcd...',
 *				'projetId' => 1234,
 *				'selectionIds' => [0,1,2...]
 *			]
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielselections
 *	
 *	/api/v002/referentiel/selections

 *	@method array getReferenceSelectionsByObject(array $parameters) 
 *	@param array{query: array} $parameters {
 *		@type array $query {
 *				
 *			}
 *	}
 *	@example $client->getReferenceSelectionsByObject([
 *		'query' => [
 *				'selectionsIds =>[1,2,3...] 
 *			]
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielselections-par-objet
 *	
 *	/api/v002/referentiel/selections-par-objet

 *	@method array referentielSelectionsParObjet(array $parameters) 
 *	@param array{query: array} $parameters {
 *		@type array $query {
 *				
 *			}
 *	}
 *	@example $client->referentielSelectionsParObjet([
 *		'query' => [
 *				'selectionsIds =>[1,2,3...] 
 *			]
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielselections-par-objet
 *	
 *	/api/v002/referentiel/selections-par-objet

 *	@method array searchObject(array $parameters) 
 *	@param array{query: array} $parameters {
 *		@type array $query {
 *				@type array $identifiants [0,1,2...]
 *				@type array $identifiers ['abc','def',...]
 *				@type integer $listeEnregistreeId 1234
 *				@type array $selectionIds [0,1,2...]
 *				@type object $center ['type' => 'Point', 'coordinates' => [4.8 (lon), 45.3 (lat)]]
 *				@type integer $radius 1234
 *				@type array $communeCodesInsee ['abc','def',...]
 *				@type array $territoireIds [0,1,2...]
 *				@type string $searchQuery 'abcd...'
 *				@type string $searchFields 'NOM|NOM_DESCRIPTION|NOM_DESCRIPTION_CRITERES'
 *				@type string $criteresQuery 'abcd...'
 *				@type string $dateDebut '2022-01-07'
 *				@type string $dateFin '2022-01-07'
 *				@type integer $first 1234
 *				@type integer $count 1234
 *				@type string $order 'PERTINENCE|NOM|DISTANCE|IDENTIFIANT|DATE_OUVERTURE|RANDOM'
 *				@type boolean $asc 
 *				@type array $locales ['abc','def',...]
 *				@type array $responseFields ['@all','informations.moyensCommunication','...']
 *				@type string $apiKey 'abcd...'
 *				@type integer $projetId 1234
 *				@type string $randomSeed 'abcd...'
 *				@type array $membreProprietaireIds [0,1,2...]
 *				@type string $searchLocale 'abcd...'
 *			}
 *	}
 *	@example $client->searchObject([
 *		'query' => [
 *				'identifiants' => [0,1,2...],
 *				'identifiers' => ['abc','def',...],
 *				'listeEnregistreeId' => 1234,
 *				'selectionIds' => [0,1,2...],
 *				'center' => ['type' => 'Point', 'coordinates' => [4.8 (lon), 45.3 (lat)]],
 *				'radius' => 1234,
 *				'communeCodesInsee' => ['abc','def',...],
 *				'territoireIds' => [0,1,2...],
 *				'searchQuery' => 'abcd...',
 *				'searchFields' => 'NOM|NOM_DESCRIPTION|NOM_DESCRIPTION_CRITERES',
 *				'criteresQuery' => 'abcd...',
 *				'dateDebut' => '2022-01-07',
 *				'dateFin' => '2022-01-07',
 *				'first' => 1234,
 *				'count' => 1234,
 *				'order' => 'PERTINENCE|NOM|DISTANCE|IDENTIFIANT|DATE_OUVERTURE|RANDOM',
 *				'asc' => ,
 *				'locales' => ['abc','def',...],
 *				'responseFields' => ['@all','informations.moyensCommunication','...'],
 *				'apiKey' => 'abcd...',
 *				'projetId' => 1234,
 *				'randomSeed' => 'abcd...',
 *				'membreProprietaireIds' => [0,1,2...],
 *				'searchLocale' => 'abcd...'
 *			]
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002recherchelist-objets-touristiques
 *	
 *	/api/v002/recherche/list-objets-touristiques

 *	@method array rechercheListObjetsTouristiques(array $parameters) 
 *	@param array{query: array} $parameters {
 *		@type array $query {
 *				@type array $identifiants [0,1,2...]
 *				@type array $identifiers ['abc','def',...]
 *				@type integer $listeEnregistreeId 1234
 *				@type array $selectionIds [0,1,2...]
 *				@type object $center ['type' => 'Point', 'coordinates' => [4.8 (lon), 45.3 (lat)]]
 *				@type integer $radius 1234
 *				@type array $communeCodesInsee ['abc','def',...]
 *				@type array $territoireIds [0,1,2...]
 *				@type string $searchQuery 'abcd...'
 *				@type string $searchFields 'NOM|NOM_DESCRIPTION|NOM_DESCRIPTION_CRITERES'
 *				@type string $criteresQuery 'abcd...'
 *				@type string $dateDebut '2022-01-07'
 *				@type string $dateFin '2022-01-07'
 *				@type integer $first 1234
 *				@type integer $count 1234
 *				@type string $order 'PERTINENCE|NOM|DISTANCE|IDENTIFIANT|DATE_OUVERTURE|RANDOM'
 *				@type boolean $asc 
 *				@type array $locales ['abc','def',...]
 *				@type array $responseFields ['@all','informations.moyensCommunication','...']
 *				@type string $apiKey 'abcd...'
 *				@type integer $projetId 1234
 *				@type string $randomSeed 'abcd...'
 *				@type array $membreProprietaireIds [0,1,2...]
 *				@type string $searchLocale 'abcd...'
 *			}
 *	}
 *	@example $client->rechercheListObjetsTouristiques([
 *		'query' => [
 *				'identifiants' => [0,1,2...],
 *				'identifiers' => ['abc','def',...],
 *				'listeEnregistreeId' => 1234,
 *				'selectionIds' => [0,1,2...],
 *				'center' => ['type' => 'Point', 'coordinates' => [4.8 (lon), 45.3 (lat)]],
 *				'radius' => 1234,
 *				'communeCodesInsee' => ['abc','def',...],
 *				'territoireIds' => [0,1,2...],
 *				'searchQuery' => 'abcd...',
 *				'searchFields' => 'NOM|NOM_DESCRIPTION|NOM_DESCRIPTION_CRITERES',
 *				'criteresQuery' => 'abcd...',
 *				'dateDebut' => '2022-01-07',
 *				'dateFin' => '2022-01-07',
 *				'first' => 1234,
 *				'count' => 1234,
 *				'order' => 'PERTINENCE|NOM|DISTANCE|IDENTIFIANT|DATE_OUVERTURE|RANDOM',
 *				'asc' => ,
 *				'locales' => ['abc','def',...],
 *				'responseFields' => ['@all','informations.moyensCommunication','...'],
 *				'apiKey' => 'abcd...',
 *				'projetId' => 1234,
 *				'randomSeed' => 'abcd...',
 *				'membreProprietaireIds' => [0,1,2...],
 *				'searchLocale' => 'abcd...'
 *			]
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002recherchelist-objets-touristiques
 *	
 *	/api/v002/recherche/list-objets-touristiques

 *	@method array searchObjectIdentifier(array $parameters) 
 *	@param array{query: array} $parameters {
 *		@type array $query {
 *				@type array $identifiants [0,1,2...]
 *				@type array $identifiers ['abc','def',...]
 *				@type integer $listeEnregistreeId 1234
 *				@type array $selectionIds [0,1,2...]
 *				@type object $center ['type' => 'Point', 'coordinates' => [4.8 (lon), 45.3 (lat)]]
 *				@type integer $radius 1234
 *				@type array $communeCodesInsee ['abc','def',...]
 *				@type array $territoireIds [0,1,2...]
 *				@type string $searchQuery 'abcd...'
 *				@type string $searchFields 'NOM|NOM_DESCRIPTION|NOM_DESCRIPTION_CRITERES'
 *				@type string $criteresQuery 'abcd...'
 *				@type string $dateDebut '2022-01-07'
 *				@type string $dateFin '2022-01-07'
 *				@type integer $first 1234
 *				@type integer $count 1234
 *				@type string $order 'PERTINENCE|NOM|DISTANCE|IDENTIFIANT|DATE_OUVERTURE|RANDOM'
 *				@type boolean $asc 
 *				@type array $locales ['abc','def',...]
 *				@type array $responseFields ['@all','informations.moyensCommunication','...']
 *				@type string $apiKey 'abcd...'
 *				@type integer $projetId 1234
 *				@type string $randomSeed 'abcd...'
 *				@type array $membreProprietaireIds [0,1,2...]
 *				@type string $searchLocale 'abcd...'
 *			}
 *	}
 *	@example $client->searchObjectIdentifier([
 *		'query' => [
 *				'identifiants' => [0,1,2...],
 *				'identifiers' => ['abc','def',...],
 *				'listeEnregistreeId' => 1234,
 *				'selectionIds' => [0,1,2...],
 *				'center' => ['type' => 'Point', 'coordinates' => [4.8 (lon), 45.3 (lat)]],
 *				'radius' => 1234,
 *				'communeCodesInsee' => ['abc','def',...],
 *				'territoireIds' => [0,1,2...],
 *				'searchQuery' => 'abcd...',
 *				'searchFields' => 'NOM|NOM_DESCRIPTION|NOM_DESCRIPTION_CRITERES',
 *				'criteresQuery' => 'abcd...',
 *				'dateDebut' => '2022-01-07',
 *				'dateFin' => '2022-01-07',
 *				'first' => 1234,
 *				'count' => 1234,
 *				'order' => 'PERTINENCE|NOM|DISTANCE|IDENTIFIANT|DATE_OUVERTURE|RANDOM',
 *				'asc' => ,
 *				'locales' => ['abc','def',...],
 *				'responseFields' => ['@all','informations.moyensCommunication','...'],
 *				'apiKey' => 'abcd...',
 *				'projetId' => 1234,
 *				'randomSeed' => 'abcd...',
 *				'membreProprietaireIds' => [0,1,2...],
 *				'searchLocale' => 'abcd...'
 *			]
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002recherchelist-identifiants
 *	
 *	/api/v002/recherche/list-identifiants

 *	@method array rechercheListIdentifiants(array $parameters) 
 *	@param array{query: array} $parameters {
 *		@type array $query {
 *				@type array $identifiants [0,1,2...]
 *				@type array $identifiers ['abc','def',...]
 *				@type integer $listeEnregistreeId 1234
 *				@type array $selectionIds [0,1,2...]
 *				@type object $center ['type' => 'Point', 'coordinates' => [4.8 (lon), 45.3 (lat)]]
 *				@type integer $radius 1234
 *				@type array $communeCodesInsee ['abc','def',...]
 *				@type array $territoireIds [0,1,2...]
 *				@type string $searchQuery 'abcd...'
 *				@type string $searchFields 'NOM|NOM_DESCRIPTION|NOM_DESCRIPTION_CRITERES'
 *				@type string $criteresQuery 'abcd...'
 *				@type string $dateDebut '2022-01-07'
 *				@type string $dateFin '2022-01-07'
 *				@type integer $first 1234
 *				@type integer $count 1234
 *				@type string $order 'PERTINENCE|NOM|DISTANCE|IDENTIFIANT|DATE_OUVERTURE|RANDOM'
 *				@type boolean $asc 
 *				@type array $locales ['abc','def',...]
 *				@type array $responseFields ['@all','informations.moyensCommunication','...']
 *				@type string $apiKey 'abcd...'
 *				@type integer $projetId 1234
 *				@type string $randomSeed 'abcd...'
 *				@type array $membreProprietaireIds [0,1,2...]
 *				@type string $searchLocale 'abcd...'
 *			}
 *	}
 *	@example $client->rechercheListIdentifiants([
 *		'query' => [
 *				'identifiants' => [0,1,2...],
 *				'identifiers' => ['abc','def',...],
 *				'listeEnregistreeId' => 1234,
 *				'selectionIds' => [0,1,2...],
 *				'center' => ['type' => 'Point', 'coordinates' => [4.8 (lon), 45.3 (lat)]],
 *				'radius' => 1234,
 *				'communeCodesInsee' => ['abc','def',...],
 *				'territoireIds' => [0,1,2...],
 *				'searchQuery' => 'abcd...',
 *				'searchFields' => 'NOM|NOM_DESCRIPTION|NOM_DESCRIPTION_CRITERES',
 *				'criteresQuery' => 'abcd...',
 *				'dateDebut' => '2022-01-07',
 *				'dateFin' => '2022-01-07',
 *				'first' => 1234,
 *				'count' => 1234,
 *				'order' => 'PERTINENCE|NOM|DISTANCE|IDENTIFIANT|DATE_OUVERTURE|RANDOM',
 *				'asc' => ,
 *				'locales' => ['abc','def',...],
 *				'responseFields' => ['@all','informations.moyensCommunication','...'],
 *				'apiKey' => 'abcd...',
 *				'projetId' => 1234,
 *				'randomSeed' => 'abcd...',
 *				'membreProprietaireIds' => [0,1,2...],
 *				'searchLocale' => 'abcd...'
 *			]
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002recherchelist-identifiants
 *	
 *	/api/v002/recherche/list-identifiants

 *	@method array getSsoToken(array $parameters) 
 *	@param array{grant_type: string, code: string, redirect_uri: string} $parameters {
 *		@type string $grant_type 
 *		@type string $code 'abcd...'
 *		@type string $redirect_uri https://www.myapp.com/...
 *	}
 *	@example $client->getSsoToken([
 *		'grant_type' =>  Available values : 'authorization_code|client_credentials|refresh_token', 
 *		'code' => 'abcd...', 
 *		'redirect_uri' => https://www.myapp.com/...
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/oauth/single-sign-on
 *	
 *	/oauth/token

 *	@method array oauthToken(array $parameters) 
 *	@param array{grant_type: string, code: string, redirect_uri: string} $parameters {
 *		@type string $grant_type 
 *		@type string $code 'abcd...'
 *		@type string $redirect_uri https://www.myapp.com/...
 *	}
 *	@example $client->oauthToken([
 *		'grant_type' =>  Available values : 'authorization_code|client_credentials|refresh_token', 
 *		'code' => 'abcd...', 
 *		'redirect_uri' => https://www.myapp.com/...
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/oauth/single-sign-on
 *	
 *	/oauth/token

 *	@method array refreshSsoToken(array $parameters) 
 *	@param array{grant_type: string, refresh_token: string, redirect_uri: string} $parameters {
 *		@type string $grant_type 
 *		@type string $refresh_token 'abcd...'
 *		@type string $redirect_uri https://www.myapp.com/...
 *	}
 *	@example $client->refreshSsoToken([
 *		'grant_type' =>  Available values : 'authorization_code|client_credentials|refresh_token', 
 *		'refresh_token' => 'abcd...', 
 *		'redirect_uri' => https://www.myapp.com/...
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/oauth/single-sign-on
 *	
 *	/oauth/token

 *	@method array getObjectById(array $parameters) 
 *	@param array{id: integer, responseFields: string, locales: string} $parameters {
 *		@type integer $id 
 *		@type string $responseFields '@all...'
 *		@type string $locales 'fr,en..'
 *	}
 *	@example $client->getObjectById([
 *		'id' => , 
 *		'responseFields' => '@all...', 
 *		'locales' => 'fr,en..' Values (examples) : 'fr|en|de|nl|it|es|ru|zh|pt-br|ja'
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002objet-touristiqueget-by-id
 *	
 *	/api/v002/objet-touristique/get-by-id/{id}

 *	@method array objetTouristiqueGetById(array $parameters) 
 *	@param array{id: integer, responseFields: string, locales: string} $parameters {
 *		@type integer $id 
 *		@type string $responseFields '@all...'
 *		@type string $locales 'fr,en..'
 *	}
 *	@example $client->objetTouristiqueGetById([
 *		'id' => , 
 *		'responseFields' => '@all...', 
 *		'locales' => 'fr,en..' Values (examples) : 'fr|en|de|nl|it|es|ru|zh|pt-br|ja'
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002objet-touristiqueget-by-id
 *	
 *	/api/v002/objet-touristique/get-by-id/{id}

 *	@method array getObjectByIdentifier(array $parameters) 
 *	@param array{identifier: string, responseFields: string, locales: string} $parameters {
 *		@type string $identifier 'SITRA2_STR_760958'
 *		@type string $responseFields '@all...'
 *		@type string $locales 'fr,en..'
 *	}
 *	@example $client->getObjectByIdentifier([
 *		'identifier' => 'SITRA2_STR_760958', 
 *		'responseFields' => '@all...', 
 *		'locales' => 'fr,en..' Values (examples) : 'fr|en|de|nl|it|es|ru|zh|pt-br|ja'
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002objet-touristiqueget-by-identifier
 *	
 *	/api/v002/objet-touristique/get-by-identifier/{identifier}

 *	@method array objetTouristiqueGetByIdentifier(array $parameters) 
 *	@param array{identifier: string, responseFields: string, locales: string} $parameters {
 *		@type string $identifier 'SITRA2_STR_760958'
 *		@type string $responseFields '@all...'
 *		@type string $locales 'fr,en..'
 *	}
 *	@example $client->objetTouristiqueGetByIdentifier([
 *		'identifier' => 'SITRA2_STR_760958', 
 *		'responseFields' => '@all...', 
 *		'locales' => 'fr,en..' Values (examples) : 'fr|en|de|nl|it|es|ru|zh|pt-br|ja'
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2/v002objet-touristiqueget-by-identifier
 *	
 *	/api/v002/objet-touristique/get-by-identifier/{identifier}

 *	@method array getUserProfile(array $parameters) 
 *	@param array{identifier: string, responseFields: string, locales: string} $parameters {
 *		@type string $identifier 'SITRA2_STR_760958'
 *		@type string $responseFields '@all...'
 *		@type string $locales 'fr,en..'
 *	}
 *	@example $client->getUserProfile([
 *		'identifier' => 'SITRA2_STR_760958', 
 *		'responseFields' => '@all...', 
 *		'locales' => 'fr,en..' Values (examples) : 'fr|en|de|nl|it|es|ru|zh|pt-br|ja'
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/oauth/services-associes-au-sso/v002ssoutilisateurprofil
 *	
 *	/api/v002/sso/utilisateur/profil

 *	@method array ssoUtilisateurProfil(array $parameters) 
 *	@param array{identifier: string, responseFields: string, locales: string} $parameters {
 *		@type string $identifier 'SITRA2_STR_760958'
 *		@type string $responseFields '@all...'
 *		@type string $locales 'fr,en..'
 *	}
 *	@example $client->ssoUtilisateurProfil([
 *		'identifier' => 'SITRA2_STR_760958', 
 *		'responseFields' => '@all...', 
 *		'locales' => 'fr,en..' Values (examples) : 'fr|en|de|nl|it|es|ru|zh|pt-br|ja'
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/oauth/services-associes-au-sso/v002ssoutilisateurprofil
 *	
 *	/api/v002/sso/utilisateur/profil

 *	@method string getUserPermissionOnObject(array $parameters) 
 *	@param array{id: integer} $parameters {
 *		@type integer $id 
 *	}
 *	@example $client->getUserPermissionOnObject([
 *		'id' => 
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/oauth/services-associes-au-sso/v002ssoutilisateurautorisationobjet-touristiquemodification
 *	
 *	/api/v002/sso/utilisateur/autorisation/objet-touristique/modification/{id}

 *	@method string ssoUtilisateurAutorisationObjetTouristiqueModification(array $parameters) 
 *	@param array{id: integer} $parameters {
 *		@type integer $id 
 *	}
 *	@example $client->ssoUtilisateurAutorisationObjetTouristiqueModification([
 *		'id' => 
 *	]) ;
 *	
 *	https://dev.apidae-tourisme.com/fr/documentation-technique/v2/oauth/services-associes-au-sso/v002ssoutilisateurautorisationobjet-touristiquemodification
 *	
 *	/api/v002/sso/utilisateur/autorisation/objet-touristique/modification/{id}
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
   * @return ResultInterface|false The result of the executed command
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

  public function __call($method, array $args): Result|string
  {
    $commandName = $method;
    /** @var Result $result */
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

  public function getOperation(string $name): Operation
  {
    return $this->description->getOperation($name);
  }
}
