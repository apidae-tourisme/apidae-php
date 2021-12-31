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
            'responseModel' => 'getResponse',
            'parameters' => [
                'query' => [
                    'type'      => 'string',
                    'location'  => 'formParam',
                    'required'  => true,
                    'filters' => [
                        [
                            'method' => '\ApidaePHP\Description\Reference::filterQuery',
                            'args' => ['@value', 'getReferenceCity', 'apiReferentielCommunesRequete']
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
            'parameters' => [
                'query' => [
                    'type'      => 'string',
                    'location'  => 'formParam',
                    'required'  => true,
                    'filters' => [
                        [
                            'method' => '\ApidaePHP\Description\Reference::filterQuery',
                            'args' => ['@value', 'getReferenceElement', 'apiReferentielElementsReferenceRequete']
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
            'parameters' => [
                'query' => [
                    'type'      => 'string',
                    'location'  => 'formParam',
                    'required'  => true,
                    'filters' => [
                        [
                            'method' => '\ApidaePHP\Description\Reference::filterQuery',
                            'args' => ['@value', 'getReferenceInternalCriteria', 'apiReferentielCriteresInternesRequete']
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
            'parameters' => [
                'query' => [
                    'type'      => 'string',
                    'location'  => 'formParam',
                    'required'  => true,
                    'filters' => [
                        [
                            'method' => '\ApidaePHP\Description\Reference::filterQuery',
                            'args' => ['@value', 'getReferenceSelection', 'apiReferentielSelectionsRequete']
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
            'parameters' => [
                'query' => [
                    'type'      => 'string',
                    'location'  => 'formParam',
                    'required'  => true,
                    'filters' => [
                        [
                            'method' => '\ApidaePHP\Description\Reference::filterQuery',
                            'args' => ['@value', 'getReferenceSelectionsByObject']
                            /** @todo Note that there is no schema on 31/12/2021 : update when schema is available */
                        ]
                    ],
                ],
            ],
        ],
        'referentielSelectionsParObjet' => ['extends' => 'getReferenceSelectionsByObject']
    );
}
