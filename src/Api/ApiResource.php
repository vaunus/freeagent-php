<?php

namespace CloudManaged\FreeAgent\Api;

use CloudManaged\FreeAgent\FreeAgent;
use CloudManaged\FreeAgent\Errors\ApiError;

class ApiResource
{
    protected $requestor;

    public function __construct(FreeAgent $freeAgent)
    {
        $this->requestor = new ApiRequestor($freeAgent);
    }

    protected function getResponseStatus($response)
    {
        if ($response->isSuccessful()) {
            return true;
        } elseif ($response->isClientError()) {
            throw new ApiError('Client Error');
        } elseif ($response->isServerError()) {
            throw new ApiError('Server Error');
        }
        throw new ApiError('An unknown error happened!');
    }

    /**
     * (GET)
     *
     * @param $url
     * @param $data
     * @return mixed
     * @throws ApiError
     */
    protected function retrieve($url, $data)
    {
        $response = $this->requestor->request($url, $data, 'get');
        if ($this->getResponseStatus($response)) {
            return $response;
        }
    }

    /**
     * (POST)
     *
     * @param $url
     * @param $data
     * @return mixed
     * @throws ApiError
     */
    protected function save($url, $data)
    {
        $response = $this->requestor->request($url, $data, 'post');
        if ($this->getResponseStatus($response)) {
            return $response;
        }
    }

    /**
     * (PUT)
     *
     * @param $url
     * @param $data
     * @return bool
     * @throws ApiError
     */
    protected function update($url, $data)
    {
        $response = $this->requestor->request($url, $data, 'put');
        return $this->getResponseStatus($response);
    }
}
