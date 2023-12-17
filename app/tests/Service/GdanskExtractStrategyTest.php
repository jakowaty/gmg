<?php declare(strict_types=1);

namespace App\Tests\Service;

use App\Service\GdanskExtractStrategy;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GdanskExtractStrategyTest extends KernelTestCase
{
    public function extractWithProperDataProvider(): array
    {
        return [
            ['<html><head></head><body><div class="opis"><div style="font-size:1.8em; font-weight:600; font-family: Kanit, sans-serif;">Letnica</div><div>Powierzchnia: 3,89 km<sup>2</sup></div><div>Liczba ludności: 1582 osób</div><div>Gęstość zaludnienia: 407 os/km<sup>2</sup></div></div></body></html>', 1]
        ];
    }

    /**
     * @param string $html
     * @return void
     *
     * @dataProvider extractWithProperDataProvider
     */
    public function testExtractWithProperData(string $html, int $id)
    {
        $strategy = new GdanskExtractStrategy();
        $dto = $strategy->processScrappedCityHtml($html, $id);

        $this->assertSame("Letnica", $dto->getName());
        $this->assertSame(3.89, $dto->getArea());
        $this->assertSame(1582, $dto->getCitizenCount());
        $this->assertSame((string)$id, $dto->getExternalId());
    }



    public function extractWithInvalidData_noDivWithNameInSourceDataProvider(): array
    {
        return [
            ['<html><head></head><body><div class="opis"><div>Powierzchnia: 3,89 km<sup>2</sup></div><div>Liczba ludności: 1582 osób</div><div>Gęstość zaludnienia: 407 os/km<sup>2</sup></div></div></body></html>', 1]
        ];
    }

    /**
     * @param string $html
     * @return void
     *
     * @dataProvider extractWithInvalidData_noDivWithNameInSourceDataProvider
     */
    public function testExtractWithInvalidData_noDivWithNameInSource(string $html, int $id)
    {
        $strategy = new GdanskExtractStrategy();
        $dto = $strategy->processScrappedCityHtml($html, $id);

        $this->assertNotEquals("Letnica", $dto->getName());
        $this->assertSame(3.89, $dto->getArea());
        $this->assertSame(1582, $dto->getCitizenCount());
        $this->assertSame((string)$id, $dto->getExternalId());
    }

    public function extractWithInvalidData_noDivWithAreaInSourceDataProvider(): array
    {
        return [
            ['<html><head></head><body><div class="opis"><div style="font-size:1.8em; font-weight:600; font-family: Kanit, sans-serif;">Letnica</div><div>Liczba ludności: 1582 osób</div><div>Gęstość zaludnienia: 407 os/km<sup>2</sup></div></div></body></html>', 1]
        ];
    }

    /**
     * @param string $html
     * @return void
     *
     * @dataProvider extractWithInvalidData_noDivWithAreaInSourceDataProvider
     */
    public function testExtractWithInvalidData_noDivWithAreaInSource(string $html, int $id)
    {
        $strategy = new GdanskExtractStrategy();

        $this->expectExceptionMessageMatches('/__construct/');

        $strategy->processScrappedCityHtml($html, $id);
    }


    public function extractWithInvalidData_noDivWithCitizensInSourceDataProvider(): array
    {
        return [
            ['<html><head></head><body><div class="opis"><div style="font-size:1.8em; font-weight:600; font-family: Kanit, sans-serif;">Letnica</div><div>Powierzchnia: 3,89 km<sup>2</sup></div><div>Gęstość zaludnienia: 407 os/km<sup>2</sup></div></div></body></html>', 1]
        ];
    }

    /**
     * @param string $html
     * @return void
     *
     * @dataProvider extractWithInvalidData_noDivWithCitizensInSourceDataProvider
     */
    public function testExtractWithInvalidData_noDivWithCitizensInSource(string $html, int $id)
    {
        $strategy = new GdanskExtractStrategy();

        $this->expectExceptionMessageMatches('/__construct/');

        $strategy->processScrappedCityHtml($html, $id);
    }
}