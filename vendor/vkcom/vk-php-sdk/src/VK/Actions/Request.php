<?php

namespace VK\Actions;

use VK\Client\VKApiRequest;

class Request
{

    /**
     * @var VKApiRequest
     */
    private $request;

    /**
     * Messages constructor.
     *
     * @param VKApiRequest $request
     */
    public function __construct(VKApiRequest $request)
    {
        $this->request = $request;
    }

    public function request(string $method, string $access_token, array $params = array())
    {
        return $this->request->post($method, $access_token, $params);
    }

    public function upload(string $upload_url, string $parameter_name, string $path)
    {
        return $this->request->upload($upload_url, $parameter_name, $path);
    }
}
