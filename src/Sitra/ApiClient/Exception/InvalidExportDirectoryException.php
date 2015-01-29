<?php

namespace Sitra\ApiClient\Exception;

class InvalidExportDirectoryException extends \InvalidArgumentException
{
    protected $message = <<<MESSAGE
Option "exportDir" is not valid or PHP can't read / write in this directory.
MESSAGE;
}
