<?php

declare(strict_types=1);

namespace Project\Domains\PublicApi\Country\Infrastructure\Doctrine\Country;

use App\Repositories\Base\Doctrine\BaseAdminEntityRepository;
use Project\Domains\Admin\Country\Domain\Country;
use Project\Domains\PublicApi\Country\Domain\CountryRepositoryInterface;
use Project\Shared\Application\Query\BaseQuery;

class CountryRepository extends BaseAdminEntityRepository implements CountryRepositoryInterface
{
    public function getEntity(): string
    {
        return Country::class;
    }

    public function get(BaseQuery $baseQueryDTO): array
    {
        return $this->entityRepository->createQueryBuilder('c')
                                    ->where('c.isActive = true')
                                    ->getQuery()
                                    ->getResult();
    }   
}
