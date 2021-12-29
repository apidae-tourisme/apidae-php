<?php

namespace ApidaePHP\Description;

use GuzzleHttp\Command\Guzzle\Parameter;

abstract class AbstractDescriptions
{
    public static array $operations;
    protected static array $schemas;
    protected  static array $schemasFiles;

    public static function encodeQuery(string|array $data, string $operation): string
    {
        $dataObject = null;
        $dataArray = null;
        $dataJson = null;

        if (is_array($data)) {
            $dataArray = $data;
            $dataJson = json_encode($data);
            $dataObject = json_decode($dataJson);
        } else {
            $dataJson = $data;
            $dataObject = json_decode($dataJson);
            $dataArray = json_decode($data, true);
            if (json_last_error() !== JSON_ERROR_NONE)
                throw new \Exception('\'query\' parameter is not a valid json string : ' . $data);
        }

        if (!isset(static::$schemas)) static::loadSchemas();

        if (isset(static::$schemas[$operation]) && isset(static::$schemas[$operation]['properties'])) {
            $validator = new \JsonSchema\Validator;
            $validator->validate($dataObject, (object)['$ref' => 'file://' . static::$schemasFiles[$operation]]);
            if (!$validator->isValid()) {
                $exceptionMessage = "JSON does not validate. Violations:\n";
                foreach ($validator->getErrors() as $error) {
                    $exceptionMessage .= printf("[%s] %s\n", $error['property'], $error['message']);
                }
                throw new \Exception($exceptionMessage);
            }
            //static::checkData(static::$schemas[$operation], $data, 'query[]', $operation);

        }

        return json_encode($data);
    }

    /**
     * @var array $schema Propriété décrite par le schema
     * @var array $value Valeurs passées par l'utilisateur dans sa requête
     * @var string $parent Nom du noeud parent testé (pour afficher des messages clairs types : Erreur sur la valeur e query[center[coordinates]]...)
     * @var string $operation Nom de l'opération d'origine (getReferenceCity...) pour afficher des messages clairs (Erreur sur l'opération getReferenceCity)
     */
    private static function checkData(array $schema, array $data, string $parent, string $operation): void
    {
        $properties = $schema['properties'];
        $propertiesNames = array_keys($schema['properties']);
        /**
         * On commence par parcourir toutes les valeurs envoyées dans la requête
         * ex : query={'communeIds':[1,2,3],...}
         * $k = 'communeIds', $v = [1,2,3]
         */

        $dataNames = array_keys($data);
        $diff = array_diff($dataNames, $propertiesNames);
        $union = array_merge($dataNames, $propertiesNames);

        if (
            isset($schema['additionalProperties'])
            && $schema['additionalProperties'] == false
            && sizeof($diff) > 0
        )
            throw new \Exception('Parameter(s) ' . implode(', ', $diff) . ' in ' . $parent . ' not allowed in ' . $operation . ' (not in ' . implode(', ', $propertiesNames) . ')');

        foreach ($union as $parameterName) {

            unset($property);
            if (isset($properties[$parameterName])) $property = $properties[$parameterName];
            /** La propriété n'existe pas, il s'agit d'un paramètre additionnel autorisé ajouté par l'utilisateur, rien à vérifier */
            else continue;

            unset($userValue);
            if (isset($values[$parameterName])) $userValue = $values[$parameterName];

            //if ($property['type'] == 'object' && $property[])

            if ($property['type'] == 'array') {
                if (!is_array($v))
                    throw new \Exception('Parameter query[' . $k . '] should be an array');
                if ($prop['items']['type'] == 'integer') {
                    if (sizeof(array_filter($v, function ($v) {
                        return !is_integer($v);
                    })) > 0)
                        throw new \Exception('Values of array query[' . $k . '] should be integers');
                }
                if ($prop['items']['type'] == 'string') {
                    if (sizeof(array_filter($v, function ($v) {
                        return !is_string($v);
                    })) > 0)
                        throw new \Exception('Values of array query[' . $k . '] should be string');
                }
            } elseif ($prop['type'] == 'integer' && !is_integer($v))
                throw new \Exception('Parameter query[' . $k . '] should be an integer');
            elseif ($prop['type'] == 'string' && !is_string($v))
                throw new \Exception('Parameter query[' . $k . '] should be a string');

            if (isset($prop['enum']) && !in_array($v, $prop['enum']))
                throw new \Exception('Value ' . $v . ' in query[' . $k . '] is not allowed (not in ' . implode(', ', $prop['enum']) . ')');
        }
    }

    private static function loadSchemas()
    {
        static::$schemas = [];
        foreach (static::$operations as $opname => $operation) {

            if (isset($operation['schema'])) {
                if (isset($operation['schema'])) {
                    $schemaFile = __DIR__ . '/../../vendor/apidae-tourisme/sit-api-v2-schemas/' . $operation['schema'] . '.schema';
                    if (file_exists($schemaFile)) {
                        static::$schemas[$opname] = json_decode(file_get_contents($schemaFile), true);
                        static::$schemasFiles[$opname] = $schemaFile;
                    }
                }
            } elseif (isset($operation['extends']) && isset(static::$schemas[$operation['extends']])) {
                static::$schemas[$opname] = static::$schemas[$operation['extends']];
            }
        }
    }
}
