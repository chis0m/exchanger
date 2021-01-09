<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Http;
use Exception;

trait HttpClient
{
    public static function request(
        string $url,
        string $method = 'GET',
        $body = [],
        array $headers = ['content-type' => 'application/json'],
        $timeout = 60,
        $thirdParty = 'Fixer'
    ) {
        if ($method == 'POST') {
            $response = Http::timeout($timeout)->withHeaders($headers)->post($url, $body);
        } else {
            $response = Http::timeout($timeout)->withHeaders($headers)->get($url, $body);
        }
        if ($response->serverError()) {
            throw new Exception("$thirdParty Server Error", $response->getStatusCode());
        }

        if (!$response->successful()) {
            throw new Exception($response['message'], $response->getStatusCode());
        }

        return $response;
    }
}
