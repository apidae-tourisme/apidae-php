<?php

namespace ApidaePHP;

use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\UriResolver;
use ApidaePHP\Client as ClientApi;
use GuzzleHttp\Client as ClientHttp;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\UriTemplate\UriTemplate;
use GuzzleHttp\Command\CommandInterface;
use GuzzleHttp\Command\Guzzle\Operation;
use GuzzleHttp\Command\Guzzle\Parameter;
use ApidaePHP\Exception\MissingTokenException;
use GuzzleHttp\Command\Guzzle\DescriptionInterface;
use GuzzleHttp\Command\Guzzle\RequestLocation\XmlLocation;
use GuzzleHttp\Command\Guzzle\RequestLocation\BodyLocation;
use GuzzleHttp\Command\Guzzle\RequestLocation\JsonLocation;
use GuzzleHttp\Command\Guzzle\RequestLocation\QueryLocation;
use GuzzleHttp\Command\Guzzle\RequestLocation\HeaderLocation;
use GuzzleHttp\Command\Guzzle\RequestLocation\FormParamLocation;
use GuzzleHttp\Command\Guzzle\RequestLocation\MultiPartLocation;
use GuzzleHttp\Command\Guzzle\RequestLocation\RequestLocationInterface;

/**
 * Serializes requests for a given command.
 */
class ApidaeSerializer
{
    /** @var RequestLocationInterface[] */
    private array $locations;

    /** @var DescriptionInterface */
    private DescriptionInterface $description;

    /** @var ClientHttp */
    private ClientHttp $clientHttp;

    /** @var ClientApi */
    private ClientApi $clientApi;

    private Request $lastRequest;

    /**
     * @param DescriptionInterface $description
     * @param RequestLocationInterface[] $requestLocations Extra request locations
     * @param ClientHttp $clientHttp
     * @param ClientApi $clientApi
     */
    public function __construct(
        DescriptionInterface $description,
        ClientHttp $clientHttp,
        ClientApi $clientApi,
        array $requestLocations = []
    ) {
        static $defaultRequestLocations;
        if (!$defaultRequestLocations) {
            $defaultRequestLocations = [
                'body'      => new BodyLocation(),
                'query'     => new QueryLocation(),
                'header'    => new HeaderLocation(),
                'json'      => new JsonLocation(),
                'xml'       => new XmlLocation(),
                'formParam' => new FormParamLocation(),
                'multipart' => new MultiPartLocation(),
            ];
        }

        $this->locations = $requestLocations + $defaultRequestLocations;
        $this->description = $description;
        $this->clientHttp = $clientHttp;
        $this->clientApi = $clientApi;
    }

    /**
     * @param CommandInterface $command
     * @return RequestInterface
     */
    public function __invoke(CommandInterface $command): RequestInterface
    {
        $request = $this->createRequest($command);
        return $this->prepareRequest($command, $request);
    }

    /**
     * Prepares a request for sending using location visitors
     *
     * @param CommandInterface $command
     * @param RequestInterface $request Request being created
     * @return RequestInterface
     * @throws \RuntimeException If a location cannot be handled
     */
    protected function prepareRequest(CommandInterface $command, RequestInterface $request): RequestInterface
    {
        $visitedLocations = [];
        $operation = $this->description->getOperation($command->getName());

        // Visit each actual parameter
        foreach ($operation->getParams() as $name => $param) {
            /** @var Parameter $param */
            $location = $param->getLocation();
            // Skip parameters that have not been set or are URI location
            if ($location == 'uri' || !$command->hasParam($name)) {
                continue;
            }
            if (!isset($this->locations[$location])) {
                throw new \RuntimeException("No location registered for $name");
            }
            $visitedLocations[$location] = true;
            $request = $this->locations[$location]->visit($command, $request, $param);
        }

        // Ensure that the after() method is invoked for additionalParameters
        /* @var Parameter $additional */
        if ($additional = $operation->getAdditionalParameters()) {
            $visitedLocations[$additional->getLocation()] = true;
        }

        // Call the after() method for each visited location
        foreach (array_keys($visitedLocations) as $location) {
            $request = $this->locations[$location]->after($command, $request, $operation);
        }

        // If this operation require an OAuth scope
        $scope = $operation->getData('scope');
        if ($scope && in_array($scope, [ClientApi::META_SCOPE, ClientApi::EDIT_SCOPE])) {
            $request = $request->withHeader(
                'Authorization',
                sprintf('Bearer %s', $this->getOAuthToken($scope))
            );
        } elseif ($scope && $scope == ClientApi::SSO_SCOPE) {
            $request = $request->withHeader(
                'Authorization',
                'Bearer ' . $this->clientApi->getAccessToken($scope)
            );
            $request = $request->withHeader('Accept', 'application/json');
        }

        // 

        // For Sso methods, client ID and secret are passed as basic auth
        if (in_array($operation->getName(), [
            'getSsoToken',
            'refreshSsoToken',
        ])) {
            $request = $request->withHeader(
                'Authorization',
                'Basic ' . base64_encode(sprintf("%s:%s", $this->clientApi->config('ssoClientId'), $this->clientApi->config('ssoSecret')))
            );

            $request = $request->withHeader('Accept', 'application/json');
        }

        return $request;
    }

    /**
     * Create a request for the command and operation
     *
     * @param CommandInterface $command
     *
     * @return RequestInterface
     * @throws \RuntimeException
     */
    protected function createRequest(CommandInterface $command): RequestInterface
    {
        $operation = $this->description->getOperation($command->getName());

        // If command does not specify a template, assume the client's base URL.
        if (null == $operation->getUri()) {
            $request = new Request(
                $operation->getHttpMethod(),
                $this->description->getBaseUri()
            );
            $this->lastRequest = $request;
            return $request;
        }

        return $this->createCommandWithUri($operation, $command);
    }

    /**
     * Create a request for an operation with a uri merged onto a base URI
     *
     * @param Operation $operation
     * @param CommandInterface $command
     *
     * @return RequestInterface
     */
    private function createCommandWithUri(Operation $operation, CommandInterface $command): RequestInterface
    {
        // Get the path values and use the client config settings
        $variables = [];
        foreach ($operation->getParams() as $name => $parameter) {
            /** @var Parameter $parameter */
            if ($parameter->getLocation() == 'uri') {
                if (isset($command[$name])) {
                    $variables[$name] = $parameter->filter($command[$name]);
                    if (!is_array($variables[$name])) {
                        $variables[$name] = (string) $variables[$name];
                    }
                }
            }
        }

        // Expand the URI template.
        $uri = UriTemplate::expand($operation->getUri(), $variables);

        $request = new Request(
            $operation->getHttpMethod(),
            UriResolver::resolve(
                $this->description->getBaseUri(),
                new Uri($uri)
            )
        );

        $this->lastRequest = $request;
        return $request;
    }

    /**
     * @param string $scope
     * @return string
     */
    protected function getOAuthToken(string $scope): string
    {
        if (isset($this->clientApi->config('accessTokens')[$scope])) {
            return $this->clientApi->config('accessTokens')[$scope];
        }

        /** @var array $auth */
        $auth = null;

        if ($scope == ClientApi::META_SCOPE) {
            if ($this->clientApi->config('metaClientId') && $this->clientApi->config('metaSecret')) {
                $auth = [
                    $this->clientApi->config('metaClientId'),
                    $this->clientApi->config('metaSecret'),
                ];
            } else
                throw new \Exception('Missing parameters metaClientId or metaSecret');
        } elseif ($scope == ClientApi::EDIT_SCOPE) {
            if ($this->clientApi->config('editClientId') && $this->clientApi->config('editSecret')) {
                $auth = [
                    $this->clientApi->config('editClientId'),
                    $this->clientApi->config('editSecret'),
                ];
            } else throw new \Exception('Missing parameters editClientId or editSecret');
        } else
            throw new \Exception('UNKNOWNED SCOPE : ' . $scope);

        $bodyTokenResponse = $this->clientHttp->get('/oauth/token', [
            'auth' => $auth,
            'query' => [
                'grant_type' => 'client_credentials',
            ],
            'headers' => [
                'accept' => 'application/json',
            ],
        ])->getBody();

        $tokenResponse = json_decode($bodyTokenResponse);

        $this->clientApi->setAccessToken($tokenResponse->scope, $tokenResponse->access_token);

        return $tokenResponse->access_token;
    }

    public function getLastRequest(): Request
    {
        return $this->lastRequest;
    }
}
