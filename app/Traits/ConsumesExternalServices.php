<?php

namespace App\Traits;

use Exception;
use GuzzleHttp\Client;

trait ConsumesExternalServices
{
    /**
     * Send a request to any service
     *
     * @return array
     */
    public function makeRequest(string $method, string $requestUrl, $queryParams = [], $formParams = [], $headers = [])
    {
        $client = new Client(['base_uri' => $this->baseUrl]);

        // TODO: remove this if heroku supports static ip/ if we move to other platform
        $formParams = array_merge($formParams, ['bypass_ip' => true]);

        $response = $client->request($method, $requestUrl, [
            'query'           => $queryParams,
            'form_params'     => $formParams,
            'headers'         => $headers,
            'timeout'         => 5,
            'connect_timeout' => 2
        ]);

        $data = $response->getBody()->getContents();
        $response = json_decode($data, true);

        if ($response && isset($response['data'])) {
            return $response;
        }

        throw new Exception("Data service didn't return expected result");
    }
}
