<?php declare(strict_types=1);

namespace App\Service;

use App\Document\District;
use App\DTO\DistrictDto;
use App\Repository\DistrictRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class DistrictService
{
    private DistrictRepository $districtRepository;

    public function __construct(DocumentManager $dm, private PaginatorInterface $paginator, private SluggerInterface $slugger)
    {
        $this->districtRepository = $dm->getRepository(District::class);
    }

    public function readInDataFromDtoToDocument(DistrictDto $dto, ?District $district)
    {
        $district?->setName($dto->getName());
        $district?->setCity($dto->getCity());
        $district?->setCitizenCount($dto->getCitizenCount());
        $district?->setExternalId($dto->getExternalId());
        $district?->setAreaInSquareMeters($dto->getArea());
    }

    public function saveOrUpdateDistricts(array $dtos): void
    {
        /** @var DistrictDto $dto */
        foreach ($dtos as $dto) {
            if (!($dto instanceof DistrictDto)) {
                throw new \Exception();
            }

            if (!$this->districtRepository->districtDataExists($dto->getCity(), $dto->getName())) {
                $district = new District();

                $this->readInDataFromDtoToDocument($dto, $district);

                $this->districtRepository->getDocumentManager()->persist($district);
            } else {
                //@TODO this should fetch bulk data instead of one by one
                $district = $this->districtRepository->findOneBy([
                    'name' => $dto->getName(),
                    'city' => $dto->getCity()
                ]);

                $this->readInDataFromDtoToDocument($dto, $district);
            }
        }

        $this->districtRepository->getDocumentManager()->flush();
    }

    public function createPagination(int $page = 1, int $limit = 100, ?array $filters = null): PaginationInterface {
        return $this->paginator->paginate(
            $this->districtRepository->getBuilderByFilters(
                $filters
            ),
            $page,
            $limit
        );
    }

    public function uploadFileForDistrict(string $districtId, UploadedFile $file): string
    {
        /** @var District $district */
        $district = $this->districtRepository->find($districtId);

        if (!$district) {
            throw new \Exception("Invalid district id");
        }

        $fileNameFromRequest =$file->getClientOriginalName();

        $newName = $this->slugger->slug($fileNameFromRequest) . '-' . uniqid() . '.' . $file->guessExtension();

        $file->move('/var/www/html/public/photos', $newName);

        $district->setFile("/photos/$newName");
        $this->districtRepository->getDocumentManager()->flush();

        return "/photos/$newName";
    }
}