<?php declare(strict_types=1);

namespace App\Scrapper\Http;

use Symfony\Component\HttpFoundation\Response;

class HttpScrapperClient
{
    public function __construct(private readonly \GuzzleHttp\Client $client) {}

    public function get(string $url): string
    {
        $response = $this->client->get($url);

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            throw new \Exception();
        }

        return $response->getBody()->getContents();
    }
}