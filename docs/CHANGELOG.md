
# Changelog
## 2022-01 - 2.0.0
### Français
* **Correction de bugs liés aux montées en version de Guzzle**
* **Ajout de vérifications avant envoi basés sur les [schemas JSON officiels](https://github.com/apidae-tourisme/sit-api-v2-schemas)**
* **Ajout des nouvelles opérations** (getMember*, getUser*, getReferenceSelectionByObject)
* **Ajout d'une [documentation basée sur les schemas](docs/schemas)**, utile pour le paramètre `query` (.md et .html)
* Ajout d'alias sur les endpoints existants, basés sur les [noms officiels des endpoints](https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2)
    * /referentiel/communes : getReferenceCity => referentielCommunes
    * /recherche/list-objets-touristiques : searchObject => rechercheListObjetsTouristiques
    * /agenda/detaille/list-identifiants : searchDetailedAgendaIdentifier => agendaDetailleListIdentifiants
* Amélioration de la documentation interne pour améliorer l'autocompletion des IDE
* Le format préférentiel sur la documentation pour le paramètre `query` est maintenant Array plutôt que String
	* old style : `$client->referencielCommunes(['query' => '{"referencesIds":[1,2]}'])`
	* new style : `$client->referencielCommunes(['query' => ['referenceIds' => [1,2]]])`
* Refonte des tests unitaires
* Refonte de la documentation
* Refonte des examples
* Corrections et optimisations diverses

### English
* **fixed issues caused by Guzzle 6 and 7 update**
* **add check before sending, based on [official json schemas](https://github.com/apidae-tourisme/sit-api-v2-schemas)**
* **new endpoints** (getMember*, getUser*, getReferenceSelectionByObject)
* **new [documentation based on schemas](docs/schemas)**, usefull for `query` parameter (.md and .html)
* add aliases of existing endpoints, based on [official API endpoints](https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services-2)
* update in-code documentation for better autocompletion of IDE
* prefered format in documentation for `query` parameters is now array instead of string (no need to json_encode before calling the operation).
	* old style : `$client->referencielCommunes(['query' => '{"referencesIds":[1,2]}'])`
	* new style : `$client->referencielCommunes(['query' => ['referenceIds' => [1,2]]])`
* new unit tests
* new documentation
* new examples
* various fixes
---

## 2019/02/18 - 1.0.5

  

* fixed Guzzle 1.0 postField > formParam

  

## 2019/02/12 - 1.0.4

  

* fixed mmoreram version to prevent composer alert.

  

## 2019/02/12 - 1.0.3

  

* update to PHP7 and Guzzle 6

* update documentation related to "*.apidae-tourisme.com*" and download archive.

  

## 2017/05/12 - 1.0.2

  

- change default URLs from "*.sitra-tourisme.com" to "*.apidae-tourisme.com"

  

## 2016/01/03 - 1.0.1

  

- manage locales and responseFields default conf in by-id requests

- various documentation updates

- added configuration for SSL behavior

  

## 2015/02/05 - 1.0.0

  

- add `exportDir` option to set where the Exports files are stored

- new `cleanExportFiles` method to remove all export files from storage

- add `responseFields` option, set automatically on object list API

- add `locales` option, set automatically on object list API

- add `count` option, set automatically on object list API

- add SSO capabilities:

- add `ssoBaseUrl`, `ssoRedirectUrl`, `ssoClientId` and `ssoSecret` options

- new `getSsoUrl` method

- new `setAccessToken` method

- new `getSsoToken` API end point

- new `refreshSsoToken` API end point

- new `getUserProfile` API end point

- new `getUserPermissionOnObject` API end point

- add tests for basic client and metadata

  

## 2015/01/15 - 0.1.0

  

- initial release