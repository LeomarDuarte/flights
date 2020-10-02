<?php

namespace App\Services\Contracts;

interface GuzzleClientInterface
{
    public function makeRequest(string $verb, string $url);
}
