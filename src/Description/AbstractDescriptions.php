<?php

namespace ApidaePHP\Description;

use GuzzleHttp\Command\Guzzle\Parameter;

abstract class AbstractDescriptions
{
    public static array $operations;

    public static function filterQuery(string|array $data, string $operation, string|null $schema = null): string
    {
        /** @var Object $dataObject */
        $dataObject = null;
        /** @var string $dataJson */
        $dataJson = null;

        if (is_array($data)) {
            $dataJson = json_encode($data);
            $dataObject = json_decode($dataJson);
        } else {
            $dataJson = $data;
            $dataObject = json_decode($data);
            if (json_last_error() !== JSON_ERROR_NONE)
                throw new \Exception('\'query\' parameter is not a valid json string : ' . $data);
        }

        if ($schema !== null && preg_match('#^a-zA-Z0-9+$#', $schema)) {
            $schemaFile = __DIR__ . '/../../vendor/apidae-tourisme/apidae-sit-schemas/api/v002/output/' . $schema . '.schema';
            if (file_exists($schemaFile)) {
                $validator = new \JsonSchema\Validator;
                $validator->validate($dataObject, (object)['$ref' => 'file://' . $schemaFile]);
                if (!$validator->isValid()) {
                    $exceptionMessage = "JSON does not validate. Violations:\n";
                    foreach ($validator->getErrors() as $error) {
                        $exceptionMessage .= printf("[%s] %s\n", $error['property'], $error['message']);
                    }
                    throw new \Exception($exceptionMessage);
                }
            }
        }

        return $dataJson;
    }
}
