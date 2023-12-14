<?php declare(strict_types=1);

namespace App\Message\Command;

use App\Enum\City;

class FetchDistrictCommand
{
    public function __construct(private City $city, private array $ids, private string $sprintfUrlPattern)
    {
    }

    /**
     * @return City
     */
    public function getCity(): City
    {
        return $this->city;
    }

    /**
     * @return array
     */
    public function getIds(): array
    {
        return $this->ids;
    }

    /**
     * @return string
     */
    public function getSprintfUrlPattern(): string
    {
        return $this->sprintfUrlPattern;
    }
}