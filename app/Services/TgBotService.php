<?php

namespace App\Services;

use http\Client;
use Illuminate\Support\Facades\Http;

class TgBotService
{
    public \GuzzleHttp\Client $client;
    public function __construct()
    {
        $baseUri = 'https://api.telegram.org/bot'. config('services.telegram.token') . '/';
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => $baseUri,
        ]);
    }

    public function getUpdates()
    {
        $responce = $this->client->get('getUpdates');
        $res = $responce->getBody()->getContents();
        return json_decode($res);
    }
}
