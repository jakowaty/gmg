<?php declare(strict_types=1);

namespace App\Factory;

use App\Enum\City;
use App\Interfaces\ExtractDataInterface;
use App\Scrapper\Http\HttpScrapperClientFactory;
use App\Service\AbstractExtractStrategy;
use App\Service\GdanskExtractStrategy;
use App\Service\HaAsStringToSquareKmConverter;
use App\Service\KrakowExtractStrategy;

class ExtractStrategyFactory
{
    public function create(City $city): AbstractExtractStrategy
    {
        return match ($city) {
            City::GDANSK => new GdanskExtractStrategy(),
            City::KRAKOW => new KrakowExtractStrategy(new HaAsStringToSquareKmConverter())
        };
    }
}