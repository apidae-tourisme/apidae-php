<?php

    /**
     * Renommer en config.inc.php pour pouvoir utiliser les exemples du dossier /examples
     */

    $config = Array(
        // Nécessaire pour la consultation
        'projetId'     => 0, // Anciennement projectId mais incohérent avec le paramètre Apidae. L'ancien projectId est encore accepté
        'apiKey'        => 'XXX',
        // Nécessaire pour les API d'écriture
        'OAuthClientId' => 'XXX',
        'OAuthSecret'   => 'XXX',
        // Nécessaire pour le SSO
		'ssoRedirectUrl'   => '[...]/vendor/sitra-tourisme/sitra-api-php/examples/sso.php', // Remplacer [...] par l'url de votre projet (https:.....)
		'ssoClientId'      => 'XXX',
        'ssoSecret'        => 'XXX',
    ) ;
