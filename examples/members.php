<?php

$config = [];
require __DIR__ . "/requires.inc.php";

$client = new \ApidaePHP\Client($config);

function showResult($r)
{
    echo '<pre style="background:green;max-height:200px;overflow:scroll;color:white;padding:10px;font-size:.8em;">';
    print_r($r);
    echo '</pre>';
}

echo "\n" . '<h2>getMemberById (' . $client->operations['getMemberById']['uri'] . ')</h2>' . "\n";
try {
    $res = $client->getMemberById(['id' => 1]);
    showResult($res);
} catch (Exception $e) {
    echo $e;
}

echo "\n" . '<h2>getMembers (' . $client->operations['getMembers']['uri'] . ')</h2>' . "\n";
try {
    $res = $client->getMembers(['query' => ["filter" => ["nom" => "Auvergne"]]]);
    echo sizeof($res) . ' results';
    showResult($res);
} catch (Exception $e) {
    echo $e;
}

echo "\n" . '<h2>getUserById (' . $client->operations['getUserById']['uri'] . ')</h2>' . "\n";
try {
    $res = $client->getUserById(['id' => 30503]);
    showResult($res);
} catch (Exception $e) {
    echo $e;
}

echo "\n" . '<h2>getUserByMail (' . $client->operations['getUserByMail']['uri'] . ')</h2>' . "\n";
try {
    $res = $client->getUserByMail(['eMail' => 'apidae-event@apidae-tourisme.com']);
    showResult($res);
} catch (Exception $e) {
    echo $e;
}

echo "\n" . '<h2>getUsersByMember (' . $client->operations['getUsersByMember']['uri'] . ')</h2>' . "\n";
try {
    $res = $client->getUsersByMember(['membre_id' => 2142]);
    echo sizeof($res) . ' results';
    showResult($res);
} catch (Exception $e) {
    echo $e;
}
/*
    echo "\n".'<h2>getAllUsers ('.$client->operations['getAllUsers']['uri'].')</h2>'."\n" ;
    try {
        $res = $client->getAllUsers();
        echo sizeof($res).' results' ;
        //showResult($res) ;
    } catch ( Exception $e ) { echo $e ; }*/