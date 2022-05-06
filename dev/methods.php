<?php

use GuzzleHttp\Command\Guzzle\Operation;
use GuzzleHttp\Command\Guzzle\Parameter;

$config = [];
require __DIR__ . "/../examples/requires.inc.php";
require __DIR__ . "/const.inc.php";

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

    $lignes = [];

    $atParameterDoc = [];

    if ($parameters) {

        /** @var array $phpStanParameters ['responseFields : string', 'id : int','...'] */
        $phpStanParameters = [];

        /** @var array $wordpressParameters ['@type string $responseFields @all','...'] */
        $wordpressParameters = [];

        /** @var array $exampleParameters ["'selectionIds' => [0,1,2...]",""] */
        $exampleParameters = [];

        foreach ($parameters as $k => $p) {
            if (in_array($k, ['projetId', 'apiKey'])) continue;

            $examples = $p->getData('examples');
            $description = $p->getDescription();

            $type = $k == 'query' ? 'array' : $p->getType();

            $required = (@$p->isRequired() ? '' : '?');

            /** @var string $wordpressParameter @type string $responseFields @all */
            $wordpressParameter = null;

            /** @var string $exampleParameter 'selectionIds' => [0,1,2...] */
            $exampleParameter = null;

            if ($k == 'query') {

                /** @var string $exampleQuery [] */
                $examplesQuery = ["'selectionsIds =>[1,2,3...] "];

                /** @var array $wpsQuery ['@type string $responseFields "@all"',...] */
                $wpsQuery = [];

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

                                    $exampleQuery = '';
                                    $wpQuery = '';

                                    $exampleQuery .= '\'' . $propertyName . '\' => ';

                                    $valuesQuery = '';

                                    if ($propertyName == 'responseFields') $valuesQuery .= '[\'@all\',\'informations.moyensCommunication\',\'...\']';
                                    elseif ($propertyName == 'center') $valuesQuery .= '[\'type\' => \'Point\', \'coordinates\' => [4.8 (lon), 45.3 (lat)]]';
                                    elseif (isset($propertyDesc['enum'])) $valuesQuery .= "'" . implode('|', $propertyDesc['enum']) . "'";
                                    elseif ($propertyDesc['type'] == 'array') {
                                        if (isset($propertyDesc['items']['type'])) {
                                            if ($propertyDesc['items']['type'] == 'integer') $valuesQuery .= '[0,1,2...]';
                                            elseif ($propertyDesc['items']['type'] == 'string') $valuesQuery .= '[\'abc\',\'def\',...]';
                                        }
                                    } elseif ($propertyDesc['type'] == 'integer') $valuesQuery .= '1234';
                                    elseif (@$propertyDesc['format'] == 'date') $valuesQuery .= '\'' . date('Y-m-d') . '\'';
                                    elseif ($propertyDesc['type'] == 'string') $valuesQuery .= '\'abcd...\'';

                                    $exampleQuery .= $valuesQuery;
                                    $wpQuery = '@type ' . $propertyDesc['type'] . ' $' . $propertyName . ' ' . $valuesQuery;

                                    $examplesQuery[] = $exampleQuery;
                                    $wpsQuery[] = $wpQuery;
                                }
                            }
                        }
                    }
                }
                $exampleParameter .= '[' . "\n *\t\t\t\t" . implode(",\n *\t\t\t\t", $examplesQuery) . "\n *\t\t\t" . ']';
                $wordpressParameter .= '{' . "\n *\t\t\t\t" . implode("\n *\t\t\t\t", $wpsQuery) . "\n *\t\t\t" . '}';
            } elseif (isset(KEYS_EXAMPLES[$k])) {
                $exampleParameter .= KEYS_EXAMPLES[$k];
                $wordpressParameter .= KEYS_EXAMPLES[$k];
            } elseif (isset(TYPES_EXAMPLES[$type])) {
                $exampleParameter .= TYPES_EXAMPLES[$type];
                $wordpressParameter .= TYPES_EXAMPLES[$type];
            } elseif (isset(FORMATS_EXAMPLES[$k])) {
                $exampleParameter .= FORMATS_EXAMPLES[$k];
                $wordpressParameter .= FORMATS_EXAMPLES[$k];
            }

            if ($p->getEnum() !== null) $exampleParameter .= " Available values : '" . implode('|', $p->getEnum()) . "'";
            elseif (isset($examples)) $exampleParameter .= " Values (examples) : '" . implode('|', $examples) . "'";

            $exampleParameters[] = "'" . $k . "' => " . $exampleParameter;

            $phpStanParameter = $k . ': ' . $type;
            $wordpressParameter = '@type ' . $type . ' $' . $k . ' ' . $wordpressParameter;

            $phpStanParameters[] = $phpStanParameter;
            $wordpressParameters[] = $wordpressParameter;
        }
    }

    $exampleParameters = array_filter($exampleParameters);

    /** @see https://stackoverflow.com/a/61369750/2846837 */
    $lignes[] = '@method ' . $return . ' ' . $operationName . '(array $parameters) ';
    $lignes[] = '@param array{' . implode(', ', $phpStanParameters) . '} $parameters {' . "\n *\t\t" . implode("\n *\t\t", $wordpressParameters) . "\n *\t" . '}';

    if (sizeof($exampleParameters) > 0) {
        $lignes[] = '@example $client->' . $operationName . "([\n *\t\t" . implode(", \n *\t\t", $exampleParameters) . "\n *\t]) ;";
    }

    $lignes[] = '';
    $lignes[] = $documentationUrl;
    $lignes[] = '';
    $lignes[] = $uri;

    $doc[$uri][] = $lignes;
}

$html = php_sapi_name() !== 'cli' && !isset($_GET['cmd']);

if (!$html) ob_start();

$startMethodDoc = '/** Magic Methods Doc */';
$startMethodDocPreg = '/\*\* Magic Methods Doc \*/';

echo $startMethodDoc . PHP_EOL;
echo '/** ' . PHP_EOL;
foreach ($doc as $uri => $methods) {
    foreach ($methods as $method) {
        echo PHP_EOL . " *\t" . implode(PHP_EOL . " *\t", $method) . PHP_EOL;
    }
}
echo ' */';

if ($html) return;

$content = ob_get_contents();
ob_clean();
@file_put_contents(__DIR__ . '/methods.txt', $content);

/**
 * Suppression des anciens commentaires methods sur src/Client.php
 */

$srcClientFile = __DIR__ . '/../src/Client.php';

$srcClient = file_get_contents($srcClientFile);
if (!$srcClient) die('Can\'t get src/Client.php content');

$srcClient = preg_replace('#(' . $startMethodDocPreg . '(.*))\nclass Client#s', $content . "\nclass Client", $srcClient);
file_put_contents($srcClientFile, $srcClient);
