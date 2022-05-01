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
        $client = new Client(['base_uri' => $this->baseUri]);

        $response = $client->request($method, $requestUrl, [
            'query'      => $queryParams,
            'form_params'=> $formParams,
            'headers'    => $headers,
        ]);

        $data = $response->getBody()->getContents();
        $response = json_decode($data, true);

        if ($response && isset($response['data'])) {
            return $response;
        }

        throw new Exception("Data service didn't return expected result");
    }
}
