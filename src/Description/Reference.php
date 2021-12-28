<?php

namespace ApidaePHP\Description;

class Reference
{
    /** @var array<mixed> $operations */
    public static array $operations = array(
        'getReferenceCity' => [
            'httpMethod' => 'POST',
            'uri' => '/api/v002/referentiel/communes',
            'docUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielcommunes',
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
        'referentielCommunes' => ['extends' => 'getReferenceCity'],
        'getReferenceElement' => [
            'extends' => 'getReferenceCity',
            'uri' => '/api/v002/referentiel/elements-reference',
            'docUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielelements-reference',
        ],
        'referencielElementsReference' => ['extends' => 'getReferenceElement'],
        'getReferenceInternalCriteria' => [
            'extends' => 'getReferenceCity',
            'uri' => '/api/v002/referentiel/criteres-internes',
            'docUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielcriteres-internes',
        ],
        'referentielCriteresInternes' => ['extends' => 'getReferenceInternalCriteria'],
        'getReferenceSelection' => [
            'extends' => 'getReferenceCity',
            'uri' => '/api/v002/referentiel/selections',
            'docUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielselections'
        ],
        'referentielSelections' => ['extends' => 'getReferenceSelection'],
        'getReferenceSelectionsByObject' => [
            'extends' => 'getReferenceCity',
            'uri' => '/api/v002/referentiel/selections-par-objet',
            'docUrl' => 'https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002referentielselections-par-objet'
        ],
        'referentielSelectionsParObjet' => ['extends' => 'getReferenceSelectionsByObject']
    );
}
