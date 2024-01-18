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

    public function getUpdates(int $offset)
    {
        $options = ['timeout' => 10];
        if ($offset > 0) {
            $options['offset'] = $offset;
        }

        $response = $this->client->get('getUpdates', [
            'query' => $options
        ]);
        $res = $response->getBody()->getContents();
        return json_decode($res);
    }


}
