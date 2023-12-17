<?php declare(strict_types=1);

namespace App\Service;

use App\DTO\DistrictDto;
use App\Enum\City;

class GdanskExtractStrategy extends AbstractExtractStrategy
{
    private function extractNumericValue(string $text, string $keyword): ?string
    {
        $matches = [];

        preg_match("/$keyword: (\d+,?\d+) /", $text, $matches);

        return isset($matches[1]) ? $matches[1] : null;
    }

    public function processScrappedCityHtml(string $data, int $id): DistrictDto
    {
        $dom = \dom_import_simplexml(new \SimpleXMLElement($data));
        $xpath = new \DOMXPath($dom->ownerDocument);
        $query = "//div[contains(@class, 'opis')]/div[1]";

        $districtName = $xpath->query($query)->item(0)->textContent;

        $districtCitizenCount = $this->extractNumericValue($data, 'Liczba ludności');
        $districtCitizenCount = is_numeric($districtCitizenCount) ? (int)$districtCitizenCount : $districtCitizenCount;

        $districtArea = $this->extractNumericValue($data, 'Powierzchnia');
        $districtArea = is_string($districtArea) ? (float)str_replace(',', '.', $districtArea) : $districtArea;

        return new DistrictDto(City::GDANSK, $districtName, (string)$id, $districtCitizenCount, $districtArea);
    }
}