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
        $message  = $e->getMessage();
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
            $message .= "\n\tTarget : " . (string) $this->request->getRequestTarget();
            $message .= "\n\tURI : " . (string) $this->request->getUri();
            $message .= "\n\tMethod : " . (string) $this->request->getMethod();
        }
        if (isset($this->response)) {
            $message .= "\nResponse :";
            $message .= "\n\t StatusCode : " . (string) $this->response->getStatusCode();
            $message .= "\n\t ReasonPhrase : " . (string) $this->response->getReasonPhrase();
            $message .= "\n\t Body : " . (string) $this->response->getBody();
        }

        parent::__construct($message, $code, $e);
    }
}
