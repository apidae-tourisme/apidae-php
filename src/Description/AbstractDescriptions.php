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
        $dataJson = null;

        if (is_array($data)) {
            $dataJson = json_encode($data);
            $dataObject = json_decode($dataJson);
        } else {
            $dataJson = $data;
            $dataObject = json_decode($dataJson);
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
        }

        return json_encode($data);
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
