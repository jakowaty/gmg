<?php declare(strict_types=1);

namespace App\Service;

use App\DTO\DistrictDto;
use App\Enum\City;
use App\Scrapper\Http\HttpScrapperClient;

class KrakowExtractStrategy extends AbstractExtractStrategy
{
    public function __construct(HttpScrapperClient $scrapperClient, private HaAsStringToSquareKmConverter $converter)
    {
        parent::__construct($scrapperClient);
    }

    private function extractDistrictName(string $html): ?string
    {
        $matches = [];

        preg_match("/Dzielnica [A-Z]+ (.+?) \(/", $html, $matches);

        return isset($matches[1]) ? $matches[1] : null;
    }

    private function extractDistrictArea(string $html): ?string
    {
        $matches = [];

        preg_match("/Powierzchnia dzielnicy:\s{0,}<strong>(\d+,\d+) ha<\/strong>/", $html, $matches);

        return isset($matches[1]) ? $matches[1] : null;
    }

    private function extractCitizenCount(string $html): ?string
    {
        $matches = [];

        preg_match("/Liczba mieszkańców \(.+\):\s{0,}<strong>\s{0,}(\d+)\s{0,}<\/strong>/", $html, $matches);

        return isset($matches[1]) ? $matches[1] : null;
    }

    public function extractDataForCity(string $sprintfUrlPattern, array $ids): array
    {
        $result = [];

        foreach ($ids as $x) {
            $data = $this->scrapperClient->get(\sprintf($sprintfUrlPattern, $x));
            $districtName = $this->extractDistrictName($data);
            $districtArea = $this->converter->convert($this->extractDistrictArea($data));
            $districtCitizenCount = (int)$this->extractCitizenCount($data);

            $result[$districtName] = new DistrictDto(City::KRAKOW, $districtName, (string)$x, $districtCitizenCount, $districtArea);
        }

        return $result;
    }

}