<?php

namespace Sitra\ApiClient\Description;

class Exports
{
    public static $operations = array(
        // @see http://www.sitra-rhonealpes.com/wiki/index.php/Sitra2_-_Exports_V2#Confirmation_de_l.27export
        'confirmExport' => [
            'httpMethod' => 'GET',
            'uri' => '/api/v002/export/confirmation',
            'responseModel' => 'getResponse',
            'parameters' => [
                'hash' => [
                    'type' => 'string',
                    'location' => 'query',
                    'required' => true,
                    'filters' => [
                        '\Sitra\ApiClient\Description\Exports::validateHash',
                    ],
                ],
            ],
        ],
    );

    /**
     * Extract the hash from the Url if url is given as hash:
     *      /api/v002/export/confirmation?hash=HASH
     *
     * @param $value
     * @return mixed
     */
    public static function validateHash($value)
    {
        if (preg_match('#hash=([^&]+)#i', $value, $matches) === 1) {
            return $matches[1];
        } else {
            return $value;
        }
    }
}
