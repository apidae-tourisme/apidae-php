<?php

use GuzzleHttp\Command\Guzzle\Operation;
use GuzzleHttp\Command\Guzzle\Parameter;

$config = [];
require __DIR__ . "/../examples/requires.inc.php";

$client = new \ApidaePHP\Client($config);

$doc = [];
$uri_doc = [];

$buffer = null;

$html = php_sapi_name() !== 'cli';

if (!$html) ob_start();

echo '<?php';

?>


namespace ApidaePHP ;

class Client {

<?php


foreach ($client->operations as $operationName => $params) {

    /** @var Operation $operation */
    $operation = $client->getOperation($operationName);

    /** @ar array<Parameter> $parameters */
    $parameters = $operation->getParams();
    $parametersNames = array_keys($parameters);

    $uri = $operation->getUri();
    $documentationUrl = $operation->getDocumentationUrl();

    $return = 'array';
    if ($operation->getResponseModel() == 'getResponseBody')
        $return = 'string';

    $paramFunc = [];
    $paramsDocs = [];

    foreach ($parameters as $k => $v) {
        /**
         * Particular case for query :
         * string expected but ApidaePHP\Description\AbstractDescriptions::filterQuery can take an array, filter and make some checks, and manage to return a string
         * */
        $type = $k == 'query' ? 'array' : $v->getType();
        $paramsDocs[] = $type . ' $' . $k;
    }

    $ligneDoc = [];
    //$ligneDoc[] = '@method ' . $return . ' ' . $operationName . '(' . implode(', ', $paramsDocs) . ') ';
    $ligneDoc[] = '@return ' . $return;

    $parameters_doc = [];
    if ($parameters) {
        foreach ($parameters as $k => $p) {
            if (in_array($k, ['projetId', 'apiKey'])) continue;

            $type = $k == 'query' ? 'array' : $p->getType();
            $typeFunc = $type;
            if ($type == 'integer') $typeFunc = 'int';

            $default = 'null';
            if (($tmp = $p->getDefault()) !== false) $default = "'" . $tmp . "'";

            $paramFunc[] = $typeFunc . ' $' . $k . (!$p->isRequired() ? ' = ' . $default : '');

            $examples = $p->getData('examples');
            $description = $p->getDescription();

            /** @var string $paramDoc @param type $paramName example */
            $paramDoc = '';
            /** @var string $paramExample @example $client->(type $paramName...) */
            $paramExample = (@$p->isRequired() ? '' : '?');;

            if ($description) {
                $paramDoc .= $description;
            }

            if ($k == 'responseFields') {
                if ($paramDoc == '') $paramDoc .= "'@all..'";
                $paramExample .= "'@all..'";
            } elseif ($k == 'identifier') {
                if ($paramDoc == '') $paramDoc .= 'Object Identifier as a string (do not mistake with regular id)';
                $paramExample .= "'sitra1234..'";
            } elseif ($p->getEnum() !== null) {
                $paramDoc .= " Available values : <code>" . implode(',', $p->getEnum()) . "</code>";
                $paramExample .= "'" . implode('|', $p->getEnum()) . "'";
            } elseif ($examples) {
                $paramDoc .= " Available values : <code>" . implode(',', $examples) . '</code>';
                $paramExample .= "'" . implode('|', $examples) . "'";
            } elseif ($k == 'locales') {
                if ($paramDoc == '') $paramDoc .= "'fr,en..'";
                $paramExample .= "'fr,en..'";
            } elseif ($k == 'query') {
                $exampleQuery = '[\'selectionIds\' => [64, 5896,..],..],..]';
                $docQuery = $exampleQuery;
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
                                $exampleQuery = "[\n\t*\t" . implode(",\n\t*\t", $examplesQuery) . "\n\t* ]";
                            }
                        }
                    }
                }
                if ($paramDoc == '') $paramDoc .= $exampleQuery;
            } elseif ($k == 'grant_type') {
                if ($paramDoc == '') $paramDoc .= "'client_credentials|authorization_code|refresh_token'";
                $paramExample .= "'client_credentials|authorization_code|refresh_token'";
            } elseif ($k == 'eMail') {
                if ($paramDoc == '') $paramDoc .= "'test@test.com'";
                $paramExample .= "'test@test.com'";
            } elseif ($k == 'redirect_uri') {
                if ($paramDoc == '') $paramDoc .= "'https://myapp.com/..'";
                $paramExample .= "'https://myapp.com/..'";
            } elseif ($type == 'string') {
                if ($paramDoc == '') $paramDoc .= "'...'";
                $paramExample .= "'...'";
            } elseif ($type == 'integer') {
                if ($paramDoc == '') $paramDoc .= '[0-9]+';
                $paramExample .= '[0-9]+';
            }
            $parameters_doc[] = $paramExample;
            $ligneDoc[] = "@param\t" . $type . "\t$" . $k . "\t" . ($p->isRequired() ? '' : '(Optional) ') . $paramDoc;
        }
    }

    $parameters_doc = array_filter($parameters_doc);

    if (sizeof($parameters_doc) > 0) {
        $ligneDoc[] = '@example <pre>$client->' . $operationName . "(" . implode(", ", $parameters_doc) . ") ;</pre>";
    }

    echo "\n\t/**";
    echo "\n\t* " . implode("\n\t* ", $ligneDoc);
    echo "\n\t*/\n\t" . 'public function ' . $operationName . '(';
    echo implode(' ,', $paramFunc);
    echo ') : ' . $return . "\n";
    echo "\t" . '{ return ' . ($return == 'array' ? '[]' : '\'abcd\'') . '; } ' . "\n\n";
}



?>

}

<?php
if ($html) return;

$content = ob_get_contents();
ob_clean();
file_put_contents(__DIR__ . '/Client.php', $content);
