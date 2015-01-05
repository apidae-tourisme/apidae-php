<?php

namespace Sitra\ApiClient\Exception;

class InvalidMetadataFormatException extends \InvalidArgumentException
{
    protected $message = <<<MESSAGE
Invalid Metadata format, please provide an array of valid JSON strings, with keys following
this schema: general, membre[s], membre[_ID], projet_1, projet[s].

Example: array('membre_42' => '{"foo": "bar"}');

Also accepted:

array('membres' => '{[
  {
     "targetId" : 21,
     "jsonData" : {"foo": "bar"}
  },
  {
     "targetId" : 12,
     "jsonData" : {"bar": "foo"}
]}');

See http://www.sitra-rhonealpes.com/wiki/index.php/API_-_services_-_v002/metadata/
MESSAGE;
}
