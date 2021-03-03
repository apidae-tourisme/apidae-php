<?php

require __DIR__."/requires.inc.php";
$client = new \Sitra\ApiClient\Client($config);

    $referenceId = 780397 ;
    $nodeId = 'test-pg' ; // Noeud accessible via le projet qui vous a fourni Oauth
    $membreId = 1157 ;

    function showMd() {
        global $client, $referenceId, $nodeId ;
        echo '<pre style="background:green;color:white;padding:10px;">' ;
            $ret = $client->getMetadata(['referenceId' => $referenceId, 'nodeId' => $nodeId]) ;
            
            echo json_encode($ret->toArray(),JSON_PRETTY_PRINT) ;
        echo '</pre>' ;
    }

    function showError($e) {
        echo '<pre style="background:red;color:white;padding:10px;">'.$e->getMessage().'</pre>' ;
    }

    showMd() ;

    $params = [
        'referenceId' => $referenceId,
        'nodeId' => $nodeId,
        'general' => '{"infoGenerale":"Mise à jour le '.date('Y-m-d H:i:s').'"}'
    ] ;
    echo '<h2>putMetadata</h2>' ;
    echo json_encode($params).'<br />' ;
    try {
        $metadata = $client->putMetadata($params);
    } catch ( Exception $e ) { showError($e) ; }

    showMd() ;

    $params = ['referenceId' => $referenceId, 'nodeId' => $nodeId] ;
    echo '<h2>deleteMetadata</h2>' ;
    echo json_encode($params).'<br />' ;
    try {
        $metadata = $client->deleteMetadata($params);
    } catch ( Exception $e ) { showError($e) ; }

    showMd() ;

    $params = [
        'referenceId' => $referenceId,
        'nodeId' => $nodeId,
        'node' => json_encode([
            'general' => json_encode(['toto' => true, 'foo' => 'bar']),
            'membres' => ([
                ['targetId' => 111, 'jsonData' => json_encode(['foo' => 'barbar'])]
            ]),
        ])
    ] ;
    echo '<h2>putMetadata</h2>' ;
    echo json_encode($params).'<br />' ;
    try {
        $metadata = $client->putMetadata($params);
    } catch ( Exception $e ) { showError($e) ; }

    showMd() ;

    $params = [
        'referenceId' => $referenceId,
        'nodeId' => $nodeId,
        'membres' => '[{"targetId": '.$membreId.', "jsonData": "{ \"foo\": \"bar\", \"bar\": 691 }" }, { "targetId": 12, "jsonData": "{ \"bar\": \"foo\" }" } ]'
    ] ;
    echo '<h2>putMetadata</h2>' ;
    echo json_encode($params).'<br />' ;
    try {
        $metadata = $client->putMetadata($params);
    } catch ( Exception $e ) { showError($e) ; }

    showMd() ;




    /*
    
    Au 03/03/2021, impossible de faire fonctionner cette syntaxe.
    Il faudrant supprimer la clé metadata et mettre directement membres.membre_21,
    mais le 21 étant dynamique, il n'est pas possible de déclarer le paramètre membres.membre_21 dans Sitra\ApiClient\Description\Metadata.

    $metadata = $client->putMetadata([
        'referenceId' => $referenceId,
        'nodeId' => $nodeId,
        'metadata' => [
            'membres.membre_'.$membreId => '{"projet test":"Mise à jour le '.date('Y-m-d H:i:s').'"}',
        ]
    ]);
*/