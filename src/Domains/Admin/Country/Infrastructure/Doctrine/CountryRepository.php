<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Infrastructure\Doctrine;

use App\Repositories\Base\Doctrine\BaseAdminEntityRepository;
use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Admin\Country\Domain\Country;
use Project\Domains\Admin\Country\Domain\CountryRepositoryInterface;
use Project\Domains\Admin\Country\Domain\ValueObjects\CountryUuid;
use Project\Shared\Application\Query\BaseQuery;

class CountryRepository extends BaseAdminEntityRepository implements CountryRepositoryInterface
{
    public function getEntity()
    {
        return Country::class;
    }

    public function paginate(BaseQuery $dataDTO, iterable $columns = ['*']): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('c')
                                        ->getQuery();

        return $this->paginator($query, $dataDTO);
    }

    public function findByUuid(CountryUuid $uuid): ?Country
    {
        $country = $this->entityRepository->find($uuid->value);

        return $country;
    }

    public function save(Country $country): void
    {
        $this->entityRepository->getEntityManager()->persist($country);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Country $country): void
    {
        $this->entityRepository->getEntityManager()->remove($country);
        $this->entityRepository->getEntityManager()->flush();
    }
}
