<?php

namespace Sitra\ApiClient;

use GuzzleHttp\Client as ClientHttp;
use GuzzleHttp\Command\CommandInterface;
use GuzzleHttp\Command\Guzzle\DescriptionInterface;
use GuzzleHttp\Command\Guzzle\Operation;
use GuzzleHttp\Command\Guzzle\Parameter;
use GuzzleHttp\Command\Guzzle\RequestLocation\BodyLocation;
use GuzzleHttp\Command\Guzzle\RequestLocation\FormParamLocation;
use GuzzleHttp\Command\Guzzle\RequestLocation\HeaderLocation;
use GuzzleHttp\Command\Guzzle\RequestLocation\JsonLocation;
use GuzzleHttp\Command\Guzzle\RequestLocation\MultiPartLocation;
use GuzzleHttp\Command\Guzzle\RequestLocation\QueryLocation;
use GuzzleHttp\Command\Guzzle\RequestLocation\RequestLocationInterface;
use GuzzleHttp\Command\Guzzle\RequestLocation\XmlLocation;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;
use Sitra\ApiClient\Exception\MissingTokenException;
use GuzzleHttp\UriTemplate\UriTemplate ;
use Sitra\ApiClient\Client as ClientApi ;

/**
 * Serializes requests for a given command.
 */
class ApidaeSerializer
{
    /** @var RequestLocationInterface[] */
    private $locations;

    /** @var DescriptionInterface */
    private $description;

    /** @var Client */
    private $clientHttp ;


    private $clientApi ;

    /**
     * @param DescriptionInterface $description
     * @param RequestLocationInterface[] $requestLocations Extra request locations
     * @param ClientHttp $clientHttp
     * @param ClientApi $clientApi
     */
    public function __construct(
      DescriptionInterface $description,
      array $requestLocations = [],
      clientHttp $clientHttp,
      ClientApi $clientApi
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
        $this->clientApi= $clientApi;
    }

    /**
     * @param CommandInterface $command
     * @return RequestInterface
     */
    public function __invoke(CommandInterface $command) : RequestInterface
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
    protected function prepareRequest(CommandInterface $command, RequestInterface $request) : RequestInterface
    {
        $visitedLocations = [];
        $operation = $this->description->getOperation($command->getName());

        // Visit each actual parameter
        foreach ($operation->getParams() as $name => $param) {
            /* @var Parameter $param */
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
        /** @var Parameter $additional */
        if ($additional = $operation->getAdditionalParameters()) {
            $visitedLocations[$additional->getLocation()] = true;
        }

        // Call the after() method for each visited location
        foreach (array_keys($visitedLocations) as $location) {
            $request = $this->locations[$location]->after($command, $request, $operation);
        }

        // If this operation require an OAuth scope
        $scope = $operation->getData('scope') ;
        if ( $scope && $scope == ClientApi::META_SCOPE )
        {
            $request = $request->withHeader(
                'Authorization',
                sprintf('Bearer %s', $this->getOAuthToken($scope))
            );
        }
        elseif ( $scope && $scope == ClientApi::SSO_SCOPE )
        {
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
    protected function createRequest(CommandInterface $command) : RequestInterface
    {
        $operation = $this->description->getOperation($command->getName());

        // If command does not specify a template, assume the client's base URL.
        if (null === $operation->getUri()) {
            return new Request(
              $operation->getHttpMethod(),
              $this->description->getBaseUri()
            );
        }

        return $this->createCommandWithUri($operation, $command);
    }

    /**
     * Create a request for an operation with a uri merged onto a base URI
     *
     * @param \GuzzleHttp\Command\Guzzle\Operation $operation
     * @param \GuzzleHttp\Command\CommandInterface $command
     *
     * @return RequestInterface
     */
    private function createCommandWithUri(Operation $operation, CommandInterface $command) : RequestInterface
    {
        // Get the path values and use the client config settings
        $variables = [];
        foreach ($operation->getParams() as $name => $arg) {
            /* @var Parameter $arg */
            if ($arg->getLocation() == 'uri') {
                if (isset($command[$name])) {
                    $variables[$name] = $arg->filter($command[$name]);
                    if (!is_array($variables[$name])) {
                        $variables[$name] = (string) $variables[$name];
                    }
                }
            }
        }

        // Expand the URI template.
        $uri = UriTemplate::expand($operation->getUri(),$variables) ;

        return new Request(
          $operation->getHttpMethod(),
          Uri::resolve($this->description->getBaseUri(), $uri)
        );
    }

    /**
     * @param string $scope
     * @return string
     */
    protected function getOAuthToken($scope) : string
    {
        if (isset($this->clientApi->config('accessTokens')[$scope])) {
            return $this->clientApi->config('accessTokens')[$scope];
        }

        if ($scope === ClientApi::META_SCOPE) {
            $bodyTokenResponse = $this->clientHttp->get('/oauth/token', [
              'auth' => [
                $this->clientApi->config('OAuthClientId'),
                $this->clientApi->config('OAuthSecret'),
              ],
              'query' => [
                'grant_type' => 'client_credentials',
              ],
              'headers' => [
                'accept' => 'application/json',
              ],
            ])->getBody();

            $tokenResponse = json_decode($bodyTokenResponse) ;
            
            $this->clientApi->setAccessToken($tokenResponse->scope,$tokenResponse->access_token) ;

            return $tokenResponse->access_token;
        } else {
            throw new MissingTokenException();
        }
    }

}