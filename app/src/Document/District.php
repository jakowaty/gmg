<?php declare(strict_types=1);

namespace App\Document;

use App\Enum\City;
use App\Repository\DistrictRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document(db: null, collection: 'district', repositoryClass: DistrictRepository::class)]
#[MongoDB\UniqueIndex(keys: ['name', 'city'])]
class District
{
    #[MongoDB\Id]
    private ?string $id = null;

    #[MongoDB\Field(type: 'string')]
    #[MongoDB\Index]
    private string $name;

    #[MongoDB\Field(type: 'string')]
    #[MongoDB\Index]
    private string $externalId;

    #[MongoDB\Field(type: 'int')]
    private int $citizenCount;

    #[MongoDB\Field(type: 'float')]
    private float $areaInSquareMeters;

    #[MongoDB\Field(type: 'string', enumType: City::class)]
    private City $city;

    #[MongoDB\Field(type: 'string', nullable: true)]
    private ?string $file;

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
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
     * @return string
     */
    public function getExternalId(): string
    {
        return $this->externalId;
    }

    /**
     * @param string $externalId
     */
    public function setExternalId(string $externalId): void
    {
        $this->externalId = $externalId;
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
    public function getAreaInSquareMeters(): float
    {
        return $this->areaInSquareMeters;
    }

    /**
     * @param float $areaInSquareMeters
     */
    public function setAreaInSquareMeters(float $areaInSquareMeters): void
    {
        $this->areaInSquareMeters = $areaInSquareMeters;
    }

    /**
     * @return City
     */
    public function getCity(): City
    {
        return $this->city;
    }

    /**
     * @param City $city
     */
    public function setCity(City $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string|null
     */
    public function getFile(): ?string
    {
        return $this->file;
    }

    /**
     * @param string|null $file
     */
    public function setFile(?string $file): void
    {
        $this->file = $file;
    }

}