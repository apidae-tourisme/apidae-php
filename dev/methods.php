<?php

use GuzzleHttp\Command\Guzzle\Operation;
use GuzzleHttp\Command\Guzzle\Parameter;

$config = [];
require __DIR__ . "/../examples/requires.inc.php";

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

    $return = 'array';
    if ($operation->getResponseModel() == 'getResponseBody')
        $return = 'string';

    $operationDoc = [];
    $operationDoc[] = '@method ' . $return . ' ' . $operationName . '(' . implode(', ', $paramsDocs) . ') ';
    //$operationDoc[] = '@return ' . $return;

    $parameters_doc = [];
    if ($parameters) {
        foreach ($parameters as $k => $p) {
            if (in_array($k, ['projetId', 'apiKey'])) continue;
            $type = $k == 'query' ? 'array' : $p->getType();
            $required = (@$p->isRequired() ? '' : '?');
            $param_doc = "" . $required . '';
            //$param_doc .= @$type . ' ';
            //$param_doc .= '\'' . $k . '\' => ';
            if ($k == 'responseFields') $param_doc .= "'@all..'";
            elseif ($k == 'identifier') $param_doc .= "'sitra1234..'";
            elseif ($p->getEnum() !== null) $param_doc .= "'" . implode('|', $p->getEnum()) . "'";
            //elseif (isset($p['examples'])) $param_doc .= "'" . implode('|', $p['examples']) . "'";
            elseif ($k == 'locales') $param_doc .= "'fr,en..'";
            /** @todo : remplacer l'exemple par un exemple généré par le schema (query ne prend pas toujours selectionIds, ex: getMembers) */
            elseif ($k == 'query') {
                $exampleQuery = '[\'selectionIds\' => [64, 5896,..],..],..]';
                $filters = $p->getFilters();
                if (($filter = array_filter($filters, function ($e) {
                    return isset($e['method']) ? preg_match('#filterQuery#', $e['method']) : false;
                })) !== false) {
                    if (isset($filter[0]['args'][2])) {
                        $schemaFile = __DIR__ . '/../vendor/apidae-tourisme/sit-api-v2-schemas/' . $filter[0]['args'][2] . '.schema';
                        if (file_exists($schemaFile)) {
                            $schemaQuery = json_decode(file_get_contents($schemaFile), true);
                            if (json_last_error() == JSON_ERROR_NONE) {
                                $examplesQuery = [];
                                foreach ($schemaQuery['properties'] as $propertyName => $propertyDesc) {
                                    $tmp = '';
                                    if (!isset($propertyDesc['required']) || $propertyDesc['required'] == 'false') $tmp .= '?';
                                    $tmp .= '\'' . $propertyName . '\' => ';
                                    if ($propertyName == 'responseFields') $tmp .= '[\'@all\',\'informations.moyensCommunication\',\'...\']';
                                    elseif ($propertyName == 'center') $tmp .= '[\'type\' => \'Point\', \'coordinates\' => [4.8 (lon), 45.3 (lat)]]';
                                    elseif (isset($propertyDesc['enum'])) $tmp .= "'" . implode('|', $propertyDesc['enum']) . "'";
                                    elseif ($propertyDesc['type'] == 'array') {
                                        if (isset($propertyDesc['items']['type'])) {
                                            if ($propertyDesc['items']['type'] == 'integer') $tmp .= '[0,1,2...]';
                                            elseif ($propertyDesc['items']['type'] == 'string') $tmp .= '[\'abc\',\'def\',...]';
                                        }
                                    } elseif ($propertyDesc['type'] == 'integer') $tmp .= '1234';
                                    elseif (@$propertyDesc['format'] == 'date') $tmp .= '\'' . date('Y-m-d') . '\'';
                                    elseif ($propertyDesc['type'] == 'string') $tmp .= '\'abcd...\'';
                                    $examplesQuery[] = $tmp;
                                }
                                $exampleQuery = "[\t\n*\t " . implode(",\n*\t ", $examplesQuery) . "\n* ]";
                            }
                        }
                    }
                }
                $param_doc .= $exampleQuery;
            } elseif ($k == 'grant_type') $param_doc .= "'client_credentials|authorization_code|refresh_token'";
            elseif ($k == 'eMail') $param_doc .= "'test@test.com'";
            elseif ($k == 'redirect_uri') $param_doc .= "'https://myapp.com/..'";
            elseif ($type == 'string') $param_doc .= "'...'";
            elseif ($type == 'integer') $param_doc .= '[0-9]+';
            $parameters_doc[] = $param_doc;
        }
    }

    $parameters_doc = array_filter($parameters_doc);

    if (sizeof($parameters_doc) > 0) {
        $operationDoc[] = '$client->' . $operationName . "(" . implode(", ", $parameters_doc) . ") ;";
    }

    $operationDoc[] = '';
    $operationDoc[] = $documentationUrl;
    $operationDoc[] = '';
    $operationDoc[] = $uri;

    $doc[$uri][] = $operationDoc;
}

$html = php_sapi_name() !== 'cli';

if (!$html) ob_start();

echo '/* Generated with dev/methods.php */' . PHP_EOL;
echo '/** ' . PHP_EOL;
foreach ($doc as $uri => $methods) {
    foreach ($methods as $method) {
        echo PHP_EOL . '* ' . implode(PHP_EOL . '* ', $method) . PHP_EOL;
    }
}
echo ' */';
echo '</pre>';

if ($html) return;

$content = ob_get_contents();
ob_clean();
file_put_contents(__DIR__ . '/methods.txt', $content);
