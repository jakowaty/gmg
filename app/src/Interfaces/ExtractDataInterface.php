<?php declare(strict_types=1);

namespace App\Interfaces;

use App\Enum\City;

interface ExtractDataInterface
{
    public function extractDataForCity(string $sprintfUrlPattern, array $ids): array;
}