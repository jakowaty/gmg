<?php declare(strict_types=1);

namespace App\Repository;

use App\Enum\City;
use Doctrine\ODM\MongoDB\Query\Builder;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;
use MongoDB\BSON\Regex;

class DistrictRepository extends DocumentRepository
{
    public function districtDataExists(City $city, string $name): bool
    {
        $qb = $this->createQueryBuilder();

        $qb
            ->addAnd(
                $qb->expr()->field('name')->equals($name)
            )
            ->addAnd(
                $qb->expr()->field('city')->equals($city)
            );

        return $qb->count()->getQuery()->execute() > 0;
    }

    public function getBuilderByFilters(?array $filters = null): Builder {
        $qb = $this->createQueryBuilder();

        if ($filters !== null) {
            $this->addCriteriaToQueryBuilderByHttpQueryFiltersParams($qb, $filters);
        }

        return $qb;
    }

    private function addCriteriaToQueryBuilderByHttpQueryFiltersParams(Builder $qb, array $filters): void
    {
        if (!empty($filters)) {
            foreach ($filters as $key => $value) {
                if (empty($value)) {
                    continue;
                }

                if ($key === 'name') {
                    $qb->addAnd(
                        $qb->expr()
                            ->addOr($qb->expr()->field('name')->equals(new Regex($value, 'i')))
                    );
                }

                if ($key === 'areaFrom') {
                    $qb->addAnd(
                        $qb->expr()->field('areaInSquareMeters')->gte($value)
                    );
                }

                if ($key === 'areaTo') {
                    $qb->addAnd(
                        $qb->expr()->field('areaInSquareMeters')->lte($value)
                    );
                }

                if ($key === 'citizensFrom') {
                    $qb->addAnd(
                        $qb->expr()->field('citizenCount')->gte($value)
                    );
                }

                if ($key === 'citizensTo') {
                    $qb->addAnd(
                        $qb->expr()->field('citizenCount')->lte($value)
                    );
                }
            }
        }
    }
}