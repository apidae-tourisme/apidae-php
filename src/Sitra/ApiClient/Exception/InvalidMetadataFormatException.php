<?php

namespace Sitra\ApiClient\Exception;

class InvalidMetadataFormatException extends \InvalidArgumentException
{
    protected $message = <<<MESSAGE
Invalid Metadata format, please provide an array of valid JSON strings, with keys following
this schema: general, node, membre[s], membres[.membre_ID], projets.projet_1, projet[s].

Examples:

    array('membres.membre_42' => '{"foo": "bar"}');

    array('membres' => '[
        {
            "targetId" : 21,
            "jsonData" : "{\"foo\": \"bar\"}"
        },
        {
            "targetId" : 12,
            "jsonData" : "{\"bar\": \"foo\"}"
        }
    ]');

    array('node' => '{
        "general": "{\"toto\":true,\"foo\":\"bar\"}",
        "membres": [
            {"targetId": 111, "jsonData": "{\"foo\":\"barbar\"}"}
        ]
    }');

See http://dev.apidae-tourisme.com/fr/documentation-technique/v2/metadonnees
MESSAGE;
}
