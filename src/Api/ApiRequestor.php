<?php

namespace CloudManaged\FreeAgent\Api;

use CloudManaged\FreeAgent\Errors\ApiError;
use Guzzle\Http\Exception\BadResponseException;
use CloudManaged\FreeAgent\FreeAgent as FreeAgentConfig;
use CloudManaged\OAuth2\Client\Provider\FreeAgent as FreeAgentAuthProvider;

abstract class ApiRequestor
{
    private $provider;

    public function __construct(FreeAgentConfig $conf)
    {
        $this->provider = new FreeAgentAuthProvider(array(
            'sandbox' => $conf->getSandbox(),
            'clientId' => $conf->getClientId(),
            'clientSecret' => $conf->getClientSecret(),
            'responseType' => $conf->getResponseType()
        ));

        $token = $this->provider->getAccessToken('refresh_token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $conf->getRefreshToken()
        ]);
        $this->provider->headers = ['Authorization' => 'Bearer ' . $token];
    }

    protected function getHttpClient()
    {
        return $this->provider->getHttpClient();
    }

    protected function getUrlBase()
    {
        return $this->provider->urlBase();
    }

    protected function request($url, $data, $method)
    {
        if (!isset($method)) {
            throw new ApiError('There should be a method!');
        }

        try {
            $client = $this->getHttpClient();

            if ($this->provider->headers) {
                $client->setDefaultOption('headers', $this->provider->headers);
            }

            $request = call_user_func_array([$client, $method], [$url, ['content-type' => 'application/json']]);
            $request->setBody(json_encode($data));
            $response = $request->send();
        } catch (BadResponseException $e) {
            throw new ApiError($e->getResponse());
        }

        return $response;
    }
}
