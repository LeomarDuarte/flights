<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Exception\GuzzleException;

use App\Services\Contracts\GuzzleClientInterface;

class GuzzleClient implements GuzzleClientInterface
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function makeRequest(string $verb, string $url)
    {
        $response = $this->client->request($verb, $url, ['headers' => array(
            'Content-Type'  => 'application/x-www-form-urlencoded'
        )]);

        return json_decode($response->getBody()->getContents());
    }
}
