<?php

namespace Sitra\ApiClient\Exception;

use GuzzleHttp\Exception\GuzzleException;

class SitraException extends \Exception
{
    protected $request;
    protected $response;

    public function __construct(GuzzleException $e)
    {
        $this->request  = $e->getRequest();
        $this->response = $e->getResponse();
        $simpleMessage  = $e->getMessage();
        $code    = 0;

        if ($this->response) {
            try {
                $decodedJson = json_decode((string) $this->response->getBody(), true);
                if ($decodedJson && isset($decodedJson['errorType'])) {
                    $simpleMessage = $decodedJson['errorType'] . ' ' . $decodedJson['message'];
                }
            } catch (\InvalidArgumentException $e) {
                // Not Json
            }

            $code = $this->response->getStatusCode();
        }

        $responseDescription = $this->response ? (string) $this->response->getBody()->getContents() : 'none';
        $requestDescription = $this->request ? (string) $this->request->getBody()->getContents() : 'none';

        $message = sprintf("%s

Request: %s

Response: %s

", $simpleMessage, $requestDescription, $responseDescription);

        parent::__construct($message, $code, $e);
    }
}
