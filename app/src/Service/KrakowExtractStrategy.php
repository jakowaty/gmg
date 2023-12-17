<?php declare(strict_types=1);

namespace App\Service;

use App\DTO\DistrictDto;
use App\Enum\City;

class KrakowExtractStrategy extends AbstractExtractStrategy
{
    public function __construct(private readonly HaAsStringToSquareKmConverter $converter){}

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

    public function processScrappedCityHtml(string $data, int $id): DistrictDto
    {
        $districtName = $this->extractDistrictName($data);
        $districtArea = $this->converter->convert($this->extractDistrictArea($data));
        $districtCitizenCount = (int)$this->extractCitizenCount($data);

        return new DistrictDto(City::KRAKOW, $districtName, (string)$id, $districtCitizenCount, $districtArea);
    }
}