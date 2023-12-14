<?php declare(strict_types=1);

namespace App\Factory;

use App\Enum\City;
use App\Interfaces\ExtractDataInterface;
use App\Scrapper\Http\HttpScrapperClientFactory;
use App\Service\GdanskExtractStrategy;
use App\Service\HaAsStringToSquareKmConverter;
use App\Service\KrakowExtractStrategy;

class ExtractStrategyFactory
{
    public function __construct(private readonly HttpScrapperClientFactory $clientFactory)
    {
    }

    public function create(City $city): ExtractDataInterface
    {
        return match ($city) {
            City::GDANSK => new GdanskExtractStrategy($this->clientFactory->createHttpScrapperClient()),
            City::KRAKOW => new KrakowExtractStrategy($this->clientFactory->createHttpScrapperClient(), new HaAsStringToSquareKmConverter())
        };
    }
}