<?php declare(strict_types=1);

namespace App\DTO;

use App\Enum\City;

class DistrictDto
{
    public function __construct(
        private City $city,
        private string $name,
        private string $externalId,
        private int $citizenCount,
        private float $area)
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getCitizenCount(): int
    {
        return $this->citizenCount;
    }

    /**
     * @param int $citizenCount
     */
    public function setCitizenCount(int $citizenCount): void
    {
        $this->citizenCount = $citizenCount;
    }

    /**
     * @return float
     */
    public function getArea(): float
    {
        return $this->area;
    }

    /**
     * @param float $area
     */
    public function setArea(float $area): void
    {
        $this->area = $area;
    }

    /**
     * @return City
     */
    public function getCity(): City
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getExternalId(): string
    {
        return $this->externalId;
    }

}