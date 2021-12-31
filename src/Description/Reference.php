<?php

namespace ApidaePHP\Description;

class Reference extends AbstractDescriptions
{
    /** @var array<mixed> $operations */
    public static array $operations = array(
        'getReferenceCity' => [
            'httpMethod' => 'POST',
            'uri' => '/api/v002/referentiel/communes',
            'documentationUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielcommunes',
            'schema' => 'apiReferentielCommunesRequete',
            'responseModel' => 'getResponse',
            'parameters' => [
                'query' => [
                    'type'      => 'string',
                    'location'  => 'formParam',
                    'required'  => true,
                    'filters' => [
                        [
                            'method' => '\ApidaePHP\Description\Reference::encodeQuery',
                            'args' => ['@value', 'getReferenceCity']
                        ]
                    ],
                ],
            ],
        ],
        'referentielCommunes' => ['extends' => 'getReferenceCity'],
        'getReferenceElement' => [
            'extends' => 'getReferenceCity',
            'uri' => '/api/v002/referentiel/elements-reference',
            'documentationUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielelements-reference',
            'schema' => 'apiReferentielElementsReferenceRequete',
            'parameters' => [
                'query' => [
                    'type'      => 'string',
                    'location'  => 'formParam',
                    'required'  => true,
                    'filters' => [
                        [
                            'method' => '\ApidaePHP\Description\Reference::encodeQuery',
                            'args' => ['@value', 'getReferenceElement']
                        ]
                    ],
                ],
            ],
        ],
        'referentielElementsReference' => ['extends' => 'getReferenceElement'],
        'getReferenceInternalCriteria' => [
            'extends' => 'getReferenceCity',
            'uri' => '/api/v002/referentiel/criteres-internes',
            'documentationUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielcriteres-internes',
            'schema' => 'apiReferentielCriteresInternesRequete',
            'parameters' => [
                'query' => [
                    'type'      => 'string',
                    'location'  => 'formParam',
                    'required'  => true,
                    'filters' => [
                        [
                            'method' => '\ApidaePHP\Description\Reference::encodeQuery',
                            'args' => ['@value', 'getReferenceInternalCriteria']
                        ]
                    ],
                ],
            ],
        ],
        'referentielCriteresInternes' => ['extends' => 'getReferenceInternalCriteria'],
        'getReferenceSelection' => [
            'extends' => 'getReferenceCity',
            'uri' => '/api/v002/referentiel/selections',
            'documentationUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielselections',
            'schema' => 'apiReferentielSelectionsRequete',
            'parameters' => [
                'query' => [
                    'type'      => 'string',
                    'location'  => 'formParam',
                    'required'  => true,
                    'filters' => [
                        [
                            'method' => '\ApidaePHP\Description\Reference::encodeQuery',
                            'args' => ['@value', 'getReferenceSelection']
                        ]
                    ],
                ],
            ],
        ],
        'referentielSelections' => ['extends' => 'getReferenceSelection'],
        'getReferenceSelectionsByObject' => [
            'extends' => 'getReferenceCity',
            'uri' => '/api/v002/referentiel/selections-par-objet',
            'documentationUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielselections-par-objet',
            //'schema' => '',
            'parameters' => [
                'query' => [
                    'type'      => 'string',
                    'location'  => 'formParam',
                    'required'  => true,
                    /*'filters' => [
                        [
                            'method' => '\ApidaePHP\Description\Reference::encodeQuery',
                            'args' => ['@value', 'apiReferentielCommunesRequete']
                        ]
                    ],*/
                ],
            ],
        ],
        'referentielSelectionsParObjet' => ['extends' => 'getReferenceSelectionsByObject']
    );
}
