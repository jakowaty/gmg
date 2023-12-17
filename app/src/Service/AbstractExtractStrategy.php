<?php declare(strict_types=1);

namespace App\Service;

use App\DTO\DistrictDto;

abstract class AbstractExtractStrategy
{
    abstract public function processScrappedCityHtml(string $data, int $id): DistrictDto;
}