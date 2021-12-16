<?php

namespace ApidaePHP\Description;

class Reference
{
    public static $operations = array(
        // @see http://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielelements-reference
        // @see http://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielcommunes
        // @see http://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielcriteres-internes
        // @see http://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielselections
        'getReferenceCity' => [
            'httpMethod' => 'POST',
            'uri' => '/api/v002/referentiel/communes',
            'responseModel' => 'getResponse',
            'parameters' => [
                'query' => [
                    'type'      => 'string',
                    'location'  => 'formParam',
                    'required'  => true,
                    'filters' => [
                        '\ApidaePHP\Description\Search::encodeSearchQuery',
                    ],
                ],
            ],
        ],
        'getReferenceElement' => [
            'extends' => 'getReferenceCity',
            'uri' => '/api/v002/referentiel/elements-reference'
        ],
        'getReferenceInternalCriteria' => [
            'extends' => 'getReferenceCity',
            'uri' => '/api/v002/referentiel/criteres-internes'
        ],
        'getReferenceSelection' => [
            'extends' => 'getReferenceCity',
            'uri' => '/api/v002/referentiel/selections'
        ],
    );
}
