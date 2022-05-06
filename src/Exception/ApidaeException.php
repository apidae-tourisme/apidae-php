<?php

namespace ApidaePHP\Exception;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Command\Exception\CommandException;

class ApidaeException extends \Exception
{
    protected ?RequestInterface $request;
    protected ?ResponseInterface $response;

    public function __construct(CommandException $e)
    {
        if (method_exists($e, 'getRequest')) {
            $this->request  = $e->getRequest();
        }
        if (method_exists($e, 'getResponse')) {
            $this->response  = $e->getResponse();
        }
        $message  = self::clean($e->getMessage());
        $code    = 0;

        if (isset($this->response)) {
            $decodedJson = json_decode((string) $this->response->getBody(), true);
            if (json_last_error() !== JSON_ERROR_NONE && is_array($decodedJson)) {
                if (isset($decodedJson['errorType'])) {
                    $message = $decodedJson['errorType'] . ' ' . $decodedJson['message'];
                }
            }

            $code = $this->response->getStatusCode();
        }

        if (isset($this->request)) {
            $message .= "\nRequest :";
            $message .= "\n\tTarget : " . (string) self::clean($this->request->getRequestTarget());
            $message .= "\n\tURI : " . (string) self::clean($this->request->getUri());
            $message .= "\n\tMethod : " . (string) $this->request->getMethod();
        }
        if (isset($this->response)) {
            $message .= "\nResponse :";
            $message .= "\n\t StatusCode : " . (string) $this->response->getStatusCode();
            $message .= "\n\t ReasonPhrase : " . (string) self::clean($this->response->getReasonPhrase());
            $message .= "\n\t Body : " . (string) self::clean($this->response->getBody());
        }

        parent::__construct($message, $code, $e);
    }

    private static function clean(string $url) : string
    {
        return preg_replace('#apiKey=[a-z0-9]+#i', 'apiKey=*****', $url) ;
    }
}
