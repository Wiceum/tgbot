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
        $queryParams = ['timeout' => 10];
        if ($offset > 0) {
            $queryParams['offset'] = $offset;
        }

        $response = $this->client->get('getUpdates', [
            'query' => $queryParams
        ]);
        $res = $response->getBody()->getContents();
        return json_decode($res);
    }

    public function sendIdToUser(object $updateObj)
    {
        $username = $updateObj->message->from->first_name;
        $userId = $updateObj->message->from->id;
        $text = 'Привет, '. $username . ' ваш id - '. $userId;

        $queryParams = [
            'text' => $text,
            'chat_id' => $updateObj->message->chat->id
            ];

        $response = $this->client->get('sendMessage', [
            'query' => $queryParams
        ]);
    }
}
