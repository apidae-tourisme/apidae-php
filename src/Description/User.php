<?php

namespace ApidaePHP\Description;

use ApidaePHP\Client as ClientApi;

class User
{
    public static $operations = array(
        // @see http://dev.apidae-tourisme.com/fr/documentation-technique/v2/oauth/services-associes-au-sso/v002ssoutilisateurprofil
        'getUserProfile' => [
            'httpMethod' => 'GET',
            'uri' => '/api/v002/sso/utilisateur/profil',
            'responseModel' => 'getResponse',
            'data' => [
                'scope' => ClientApi::SSO_SCOPE,
            ],
        ],
        'ssoUtilisateurProfil' => ['extends' => 'getUserProfile'],

        // @see http://dev.apidae-tourisme.com/fr/documentation-technique/v2/oauth/services-associes-au-sso/v002ssoutilisateurautorisationobjet-touristiquemodification
        'getUserPermissionOnObject' => [
            'httpMethod' => 'GET',
            'uri' => '/api/v002/sso/utilisateur/autorisation/objet-touristique/modification/{id}',
            'responseModel' => 'getResponseBody',
            'parameters' => [
                'id' => [
                    'type' => 'integer',
                    'location' => 'uri',
                    'required' => true,
                ],
            ],
            'data' => [
                'scope' => ClientApi::SSO_SCOPE,
            ],
        ],
        'ssoUtilisateurAutorisationObjetTouristiqueModification' => ['extends' => 'getUserPermissionOnObject']
    );
}
