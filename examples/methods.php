<?php

$config = [];
require __DIR__ . "/requires.inc.php";

$client = new \ApidaePHP\Client($config);

function getParam($params, $param): mixed
{
    global $client;
    if (isset($params[$param])) return $params[$param];
    elseif (isset($params['extends']) && isset($client->operations[$params['extends']])) {
        return getParam($client->operations[$params['extends']], $param);
    } else return false;
}

$doc = '';
$last_uri = '';

foreach ($client->operations as $operation => $params) {

    $uri = getParam($params, 'uri');
    $documentationUrl = getParam($params, 'documentationUrl');
    if ($last_uri != $uri) {
        $doc .= '*' . "\n";
        $doc .= '* ' . $uri . "\n";
        $doc .= '* @see ' . $documentationUrl . "\n";
    }
    $doc .= '* @method array ' . $operation . '() ' . $operation;

    $parameters_doc = [];
    $parameters = getParam($params, 'parameters');
    if ($parameters) {
        foreach ($parameters as $k => $p) {
            if (in_array($k, ['projetId', 'apiKey'])) continue;
            $required = (@$p['required'] == true ? '' : '?');
            $param_doc = $required . '' . @$p['type'] . ' ' . '\'' . $k . '\' => ';
            if ($k == 'responseFields') $param_doc .= "'@all..'";
            elseif ($k == 'identifier') $param_doc .= "'sitra1234..'";
            elseif (isset($p['enum'])) $param_doc .= "'" . implode('|', $p['enum']) . "'";
            elseif (isset($p['examples'])) $param_doc .= "'" . implode('|', $p['examples']) . "'";
            elseif ($k == 'locales') $param_doc .= "'fr,en..'";
            elseif ($k == 'query') $param_doc .= '["selectionIds" => [64, 5896,..],..],..]';
            elseif ($k == 'grant_type') $param_doc .= "'client_credentials|authorization_code|refresh_token'";
            elseif ($k == 'eMail') $param_doc .= "'test@test.com'";
            elseif ($k == 'redirect_uri') $param_doc .= "'https://myapp.com/..'";
            elseif ($p['type'] == 'string') $param_doc .= "'...'";
            elseif ($p['type'] == 'integer') $param_doc .= '[0-9]+';
            $parameters_doc[] = $param_doc;
        }
    }

    $doc .= '(';
    if (sizeof($parameters_doc)) $doc .= '[' . implode(', ', $parameters_doc) . ']';
    $doc .= ')';
    $doc .= "\n";

    $last_uri = $uri;
}

echo '<pre>';
echo '/** Generated with examples/methods.php' . "\n" . $doc . ' */';
echo '</pre>';
