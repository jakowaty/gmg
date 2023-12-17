<?php declare(strict_types=1);

namespace App\Message\Handler;

use App\Factory\ExtractStrategyFactory;
use App\Message\Command\FetchDistrictCommand;
use App\Scrapper\Http\HttpScrapperClient;
use App\Service\DistrictService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class FetchDistrictCommandHandler
{
    public function __construct(
        private readonly ExtractStrategyFactory $extractStrategyFactory,
        private readonly DistrictService $districtService,
        private readonly HttpScrapperClient $scrapperClient
    ){}

    public function __invoke(FetchDistrictCommand $command): void
    {
        $extractStrategy = $this->extractStrategyFactory->create($command->getCity());
        $scrappedDataDtos = [];

        foreach ($command->getIds() as $id) {
            try {
                $data = $this->scrapperClient->get(\sprintf($command->getSprintfUrlPattern(), $id));
                $districtDto = $extractStrategy->processScrappedCityHtml($data, $id);

                $scrappedDataDtos[] = $districtDto;
            } catch (\Throwable $e) {}
        }

        try {
            $this->districtService->saveOrUpdateDistricts($scrappedDataDtos);
        } catch (\Throwable $e) {}
    }
}