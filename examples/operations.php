<?php

$config = [];
require __DIR__ . "/requires.inc.php";

$client = new \ApidaePHP\Client($config);

function getParam($params, $param)
{
    global $client;
    if (isset($params[$param])) return $params[$param];
    elseif (isset($params['extends']) && isset($client->operations[$params['extends']])) {
        return getParam($client->operations[$params['extends']], $param);
    } else return false;
}

$group = [];
foreach ($client->operations as $operation => $params) {
    $method = getParam($params, 'httpMethod');
    $group[$method . ' ' . getParam($params, 'uri')][$operation] = $params;
}

$eol = '<br />' . "\n";

echo '<h1>Operations</h1>';

foreach ($group as $uri => $operations) {

    $ops = array_keys($operations);
    $first_op = $operations[array_values($ops)[0]];
    $summary = getParam($first_op, 'summary');
    $documentationUrl = getParam($first_op, 'documentationUrl');

    echo '<h2> ' . $uri . '</h2>';
    echo '<h3>Methods : ' . implode(', ', $ops) . '</h3>';

    if ($summary) echo $summary . $eol;
    if ($documentationUrl) echo '<a href="' . $documentationUrl . '">' . $documentationUrl . '</a>' . $eol;
}
