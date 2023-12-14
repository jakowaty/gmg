<?php declare(strict_types=1);

namespace App\Message\Handler;

use App\Factory\ExtractStrategyFactory;
use App\Message\Command\FetchDistrictCommand;
use App\Service\DistrictService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class FetchDistrictCommandHandler
{
    public function __construct(
        private ExtractStrategyFactory $extractStrategyFactory,
        private DistrictService $districtService
    ){}

    public function __invoke(FetchDistrictCommand $command)
    {
        $scrapperExtractor = $this->extractStrategyFactory->create($command->getCity());
        $scrappedDataDtos = $scrapperExtractor->extractDataForCity($command->getSprintfUrlPattern(), $command->getIds());

        $this->districtService->saveOrUpdateDistricts($scrappedDataDtos);
    }
}