<?php

namespace CloudManaged\FreeAgent\Api;

use CloudManaged\FreeAgent\FreeAgent;
use CloudManaged\FreeAgent\Errors\ApiError;

class ApiResource extends ApiRequestor
{
    public function __construct(FreeAgent $freeAgent)
    {
        parent::__construct($freeAgent);
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

    protected function getResponseObjectId($response)
    {
        $location = $response->getLocation();
        if (!empty($location)) {
            return end(explode("/", $location));
        }
        return true;
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
        $response = $this->request($url, $data, 'get');
        if ($this->getResponseStatus($response)) {
            return $this->getResponseObjectId($response);
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
        $response = $this->request($url, $data, 'post');
        if ($this->getResponseStatus($response)) {
            return $this->getResponseObjectId($response);
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
        $response = $this->request($url, $data, 'put');
        if ($this->getResponseStatus($response)) {
            return $this->getResponseObjectId($response);
        }
    }
}
