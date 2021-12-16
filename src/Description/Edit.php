<?php

namespace ApidaePHP\Description;

use ApidaePHP\Client as ClientApi;

class Edit
{
    public static $operations = array(
        // @see https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-decriture/v002autorisationobjet-touristiquemodification
        'getEditAutorisation' => [
            'httpMethod' => 'GET',
            'uri' => '/api/v002/autorisation/objet-touristique/modification/{id}',
            'responseModel' => 'getResponseBody',
            'parameters' => [
                'id' => [
                    'type' => 'integer',
                    'location' => 'uri',
                    'required' => true,
                ],
                'tokenSSO' => [
                    'type' => 'string',
                    'location' => 'query',
                    'required' => false,
                ]
            ],
            'data' => [
                'scope' => ClientApi::EDIT_SCOPE,
            ],
        ],
        'autorisationObjetTouristiqueModification' => ['extends' => 'getEditAutorisation']
    );
}
