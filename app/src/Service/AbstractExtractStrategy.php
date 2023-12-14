<?php declare(strict_types=1);

namespace App\Service;

use App\Interfaces\ExtractDataInterface;
use App\Scrapper\Http\HttpScrapperClient;

abstract class AbstractExtractStrategy implements ExtractDataInterface
{
    public function __construct(protected HttpScrapperClient $scrapperClient)
    {
    }
}