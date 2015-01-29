<?php

namespace Sitra\ApiClient\Description;

use Sitra\ApiClient\Subscriber\AuthenticationSubscriber;

class User
{
    public static $operations = array(
        // @see http://www.sitra-rhonealpes.com/wiki/index.php/API_-_services_-_v002/sso/utilisateur/profil
        'getUserProfile' => [
            'httpMethod' => 'GET',
            'uri' => '/api/v002/sso/utilisateur/profil',
            'responseModel' => 'getResponse',
            'data' => [
                'scope' => AuthenticationSubscriber::SSO_SCOPE,
            ],
        ],
        // @see http://www.sitra-rhonealpes.com/wiki/index.php/API_-_services_-_v002/sso/utilisateur/autorisation/objet-touristique/modification/
        'getUserPermissionOnObject' => [
            'httpMethod' => 'GET',
            'uri' => '/api/v002/sso/utilisateur/autorisation/objet-touristique/modification/{id}',
            'responseModel' => 'getResponse',
            'parameters' => [
                'id' => [
                    'type' => 'integer',
                    'location' => 'uri',
                    'required' => true,
                ],
            ],
            'data' => [
                'scope' => AuthenticationSubscriber::SSO_SCOPE,
            ],
        ],
    );
}
