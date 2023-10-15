<?php

declare(strict_types=1);

namespace Project\Domains\PublicApi\Currency\Infrastructure\Doctrine\Currency;

use App\Repositories\Base\Doctrine\BaseAdminEntityRepository;
use Project\Domains\Admin\Currency\Domain\Currency\Currency;
use Project\Domains\PublicApi\Currency\Domain\Currency\CurrencyRepositoryInterface;
use Project\Shared\Application\Query\BaseQuery;

class CurrencyRepository extends BaseAdminEntityRepository implements CurrencyRepositoryInterface
{
    public function getEntity(): string
    {
        return Currency::class;
    }

    public function get(BaseQuery $baseQueryDTO): array
    {
        return $this->entityRepository->createQueryBuilder('c')
                                    ->where('c.isActive = true')
                                    ->getQuery()
                                    ->getResult();
    }
}
