<?php

namespace ApidaePHP\Traits;

use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\Query;
use ApidaePHP\Client as ClientApi;
use ApidaePHP\Exception\MissingTokenException;

trait Sso
{

    /**
     * @return string
     */
    public function getSsoUrl($ssoRedirectUrl = null): string
    {
        $params = array(
            'response_type' => 'code',
            'client_id'     => $this->config['ssoClientId'],
            'redirect_uri'  => $ssoRedirectUrl != null ? $ssoRedirectUrl : $this->config['ssoRedirectUrl'],
            'scope'         => ClientApi::SSO_SCOPE,
        );

        $query = Query::build($params);

        $uri = new Uri($this->config['ssoBaseUrl']);
        $uri = $uri->withPath('/oauth/authorize');
        $uri = $uri->withQuery($query);

        return (string) $uri;
    }

    /**
     * @param string $scope
     * @param string $token
     */
    public function setAccessToken($scope, $token)
    {
        $this->config['accessTokens'][$scope] = $token;
    }

    /**
     * @param string $scope
     * @return string
     */
    public function getAccessToken($scope): string
    {
        if (isset($this->config['accessTokens'][$scope])) {
            return $this->config['accessTokens'][$scope];
        } else {
            throw new MissingTokenException();
        }
    }
}
