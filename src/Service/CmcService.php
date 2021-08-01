<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CmcService 
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getApiInfo(string $cryptoName): array
    {
        $response = $this->client->request(
            'GET',
            'https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest',
            [
                'headers' => [
                    'Accepts' => 'application/json',
                    'X-CMC_PRO_API_KEY' => '%env(resolve:API_KEY)%'
                ],
                'query' => [
                    'symbol' => $cryptoName,
                    'convert' => 'EUR'
                ]
            ]
        );

        $content = $response->getContent();
        $content = $response->toArray();

        return $content;
    }
    public function getApiPrice(string $cryptoName): float
    {
        $getApiPrice = $this->getApiInfo($cryptoName);

        $currentPrice = $getApiPrice['data'][$cryptoName]['quote']['EUR']['price'];

        return $currentPrice;
    }
}

