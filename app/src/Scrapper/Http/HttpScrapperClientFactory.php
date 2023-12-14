<?php declare(strict_types=1);

namespace App\Scrapper\Http;

use GuzzleHttp\Client;

class HttpScrapperClientFactory
{
    public function createHttpScrapperClient(): HttpScrapperClient
    {
        $guzzle = new Client();

        return new HttpScrapperClient($guzzle);
    }
}