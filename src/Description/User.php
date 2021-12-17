<?php

namespace ApidaePHP\Description;

use ApidaePHP\Client as ClientApi;

class User
{
    /** @var array<mixed> $operations */
    public static array $operations = array(
        'getUserProfile' => [
            'httpMethod' => 'GET',
            'uri' => '/api/v002/sso/utilisateur/profil',
            'docUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/oauth/services-associes-au-sso/v002ssoutilisateurprofil',
            'responseModel' => 'getResponse',
            'data' => [
                'scope' => ClientApi::SSO_SCOPE,
            ],
        ],
        'ssoUtilisateurProfil' => ['extends' => 'getUserProfile'],

        'getUserPermissionOnObject' => [
            'httpMethod' => 'GET',
            'uri' => '/api/v002/sso/utilisateur/autorisation/objet-touristique/modification/{id}',
            'docUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/oauth/services-associes-au-sso/v002ssoutilisateurautorisationobjet-touristiquemodification',
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
