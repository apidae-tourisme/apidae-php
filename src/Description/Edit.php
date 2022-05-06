<?php

namespace ApidaePHP\Description;

use ApidaePHP\Client as ClientApi;

class Edit extends AbstractDescriptions
{
    /** @var array<mixed> $operations */
    public static array $operations = array(
        // @see https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-decriture/v002autorisationobjet-touristiquemodification
        'getEditAutorisation' => [
            'httpMethod' => 'GET',
            'uri' => '/api/v002/autorisation/objet-touristique/modification/{id}',
            'documentationUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-decriture/v002autorisationobjet-touristiquemodification',
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
