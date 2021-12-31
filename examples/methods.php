<?php

use GuzzleHttp\Command\Guzzle\Operation;
use GuzzleHttp\Command\Guzzle\Parameter;

$config = [];
require __DIR__ . "/requires.inc.php";

$client = new \ApidaePHP\Client($config);

$doc = [];
$uri_doc = [];

foreach ($client->operations as $operationName => $params) {

    /** @var Operation $operation */
    $operation = $client->getOperation($operationName);

    /** @ar array<Parameter> $parameters */
    $parameters = $operation->getParams();
    $parametersNames = array_keys($parameters);

    $uri = $operation->getUri();
    $documentationUrl = $operation->getDocumentationUrl();

    $paramsDocs = [];
    foreach ($parameters as $k => $v) {
        /**
         * Particular case for query :
         * string expected but ApidaePHP\Description\AbstractDescriptions::filterQuery can take an array, filter and make some checks, and manage to return a string
         * */
        $type = $k == 'query' ? 'array' : $v->getType();
        $paramsDocs[] = $type . ' $' . $k;
    }

    $operationDoc = [];

    $operationDoc[] = '@method Array ' . $operationName . '(' . implode(', ', $paramsDocs) . ') ';
    $operationDoc[] = '@return Array';

    $parameters_doc = [];
    if ($parameters) {
        foreach ($parameters as $k => $p) {
            if (in_array($k, ['projetId', 'apiKey'])) continue;
            $type = $k == 'query' ? 'Array' : $p->getType();
            $required = (@$p->isRequired() ? '' : '?');
            $param_doc = $required . '';
            //$param_doc .= @$type . ' ';
            //$param_doc .= '\'' . $k . '\' => ';
            if ($k == 'responseFields') $param_doc .= "'@all..'";
            elseif ($k == 'identifier') $param_doc .= "'sitra1234..'";
            elseif ($p->getEnum() !== null) $param_doc .= "'" . implode('|', $p->getEnum()) . "'";
            //elseif (isset($p['examples'])) $param_doc .= "'" . implode('|', $p['examples']) . "'";
            elseif ($k == 'locales') $param_doc .= "'fr,en..'";
            /** @todo : remplacer l'exemple par un exemple généré par le schema (query ne prend pas toujours selectionIds, ex: getMembers) */
            elseif ($k == 'query') $param_doc .= '[\'selectionIds\' => [64, 5896,..],..],..]';
            elseif ($k == 'grant_type') $param_doc .= "'client_credentials|authorization_code|refresh_token'";
            elseif ($k == 'eMail') $param_doc .= "'test@test.com'";
            elseif ($k == 'redirect_uri') $param_doc .= "'https://myapp.com/..'";
            elseif ($type == 'string') $param_doc .= "'...'";
            elseif ($type == 'integer') $param_doc .= '[0-9]+';
            $parameters_doc[] = $param_doc;
        }
    }

    if (sizeof($parameters_doc)) {
        $operationDoc[] = $operationName . '(' . implode(', ', $parameters_doc) . ')';
    }

    $uri_doc[$uri] = $documentationUrl;

    $doc[$uri][] = $operationDoc;
}

echo '<pre>';
echo '/* Generated with examples/methods.php */' . PHP_EOL;
echo '/** ' . PHP_EOL;
foreach ($doc as $uri => $methods) {
    foreach ($methods as $method) {
        echo PHP_EOL . '* ' . implode(PHP_EOL . '* ', $method);
        echo PHP_EOL . '* ' . $uri;
        echo PHP_EOL . '* ';
    }
}
echo ' */';
echo '</pre>';