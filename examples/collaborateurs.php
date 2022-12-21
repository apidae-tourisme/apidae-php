<?php

use ApidaePHP\Exception\ApidaeException;

$config = [];
require __DIR__ . "/requires.inc.php";

$client = new \ApidaePHP\Client($config);

$referenceId = 4640947;

try {
    $collaborateurs = $client->getCollaborateurs([
        'query' => ['referenceIds' => [$referenceId]]
    ]);
    var_dump($collaborateurs) ;
} catch (ApidaeException $e) {
    echo $e->getcode() ;
    echo $e->getMessage() ;
    die() ;
} catch (Exception $e) {
    echo $e->getcode() ;
    echo $e->getMessage() ;
    die() ;
}
