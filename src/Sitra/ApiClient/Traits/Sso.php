<?php

    namespace Sitra\ApiClient\Traits ;

    use Sitra\ApiClient\Subscriber\AuthenticationSubscriber ;
    use Sitra\ApiClient\Exception\MissingTokenException ;
    use GuzzleHttp\Psr7\Uri;

    trait Sso {

        /**
         * @return string
         */
        public function getSsoUrl($ssoRedirectUrl=null) : string
        {
            $params = array(
            'response_type' => 'code',
            'client_id'     => $this->config['ssoClientId'],
            'redirect_uri'  => $ssoRedirectUrl != null ? $ssoRedirectUrl : $this->config['ssoRedirectUrl'],
            'scope'         => AuthenticationSubscriber::SSO_SCOPE,
            );

            $query = \GuzzleHttp\Psr7\build_query($params);

            $uri = new Uri($this->config['ssoBaseUrl']);
            $uri = $uri->withPath('/oauth/authorize');
            $uri = $uri->withQuery($query);

            return (string) $uri;
        }

        /**
         * @param $scope
         * @param $token
         */
        public function setAccessToken($scope, $token)
        {
            $this->config['accessTokens'][$scope] = $token ;
        }

        /**
         * @param $scope
         * @return string
         */
        public function getAccessToken($scope) : string
        {
            if ( isset($this->config['accessTokens'][$scope]) )
            {
                return $this->config['accessTokens'][$scope] ;
            } else {
                throw new MissingTokenException();
            }
        }

    }