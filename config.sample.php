<?php

/**
 * Renommer en config.inc.php pour pouvoir utiliser les exemples du dossier /examples
 */

$config = array(
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
    'exportDir' => realpath(dirname(__FILE__)) . '/examples/export/'
);

// For demo-export.php purpose
/*
$exportNotification = array(
    "statut" => "SUCCESS",
    "reinitialisation" => "false",
    "projetId" => "672",
    "urlConfirmation" => "https://api.apidae-tourisme.com/api/v002/export/confirmation?hash=672_20150106-1344_V4BjvT",
    "ponctuel" => "true",
    "urlRecuperation" => "https://export.apidae-tourisme.com/exports/672_20150106-1344_V4BjvT.zip",
);
*/