<?php

namespace Sitra\ApiClient\Description;

class Reference
{
    public static $operations = array(
        // @see http://www.sitra-rhonealpes.com/wiki/index.php/Sitra2_-_API_V2#R.C3.A9cup.C3.A9ration_d.27.C3.A9l.C3.A9ments_du_r.C3.A9f.C3.A9rentiel
        'getReferenceCity' => [
            'httpMethod' => 'POST',
            'uri' => '/api/v002/referentiel/communes',
            'responseModel' => 'getResponse',
            'parameters' => [
                'query' => [
                    'type'      => 'string',
                    'location'  => 'postField',
                    'required'  => true,
                    'filters' => [
                        '\Sitra\ApiClient\Description\Search::encodeSearchQuery',
                    ],
                ]
            ],
        ],
        'getReferenceElement' => [
            'httpMethod' => 'POST',
            'uri' => '/api/v002/referentiel/elements-reference',
            'responseModel' => 'getResponse',
            'parameters' => [
                'query' => [
                    'type'      => 'string',
                    'location'  => 'postField',
                    'required'  => true,
                    'filters' => [
                        '\Sitra\ApiClient\Description\Search::encodeSearchQuery',
                    ],
                ]
            ],
        ],
        'getReferenceInternalCriteria' => [
            'httpMethod' => 'POST',
            'uri' => '/api/v002/referentiel/criteres-internes',
            'responseModel' => 'getResponse',
            'parameters' => [
                'query' => [
                    'type'      => 'string',
                    'location'  => 'postField',
                    'required'  => true,
                    'filters' => [
                        '\Sitra\ApiClient\Description\Search::encodeSearchQuery',
                    ],
                ]
            ],
        ],
        'getReferenceSelection' => [
            'httpMethod' => 'POST',
            'uri' => '/api/v002/referentiel/selections',
            'responseModel' => 'getResponse',
            'parameters' => [
                'query' => [
                    'type'      => 'string',
                    'location'  => 'postField',
                    'required'  => true,
                    'filters' => [
                        '\Sitra\ApiClient\Description\Search::encodeSearchQuery',
                    ],
                ]
            ],
        ],
    );
}
