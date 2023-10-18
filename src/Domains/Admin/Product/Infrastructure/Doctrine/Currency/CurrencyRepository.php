<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Infrastructure\Doctrine\Currency;

use App\Repositories\Base\Doctrine\BaseAdminEntityRepository;
use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Admin\Product\Domain\Currency\Currency;
use Project\Domains\Admin\Product\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Currency\ValueObjects\Uuid;
use Project\Shared\Application\Query\BaseQuery;

final class CurrencyRepository extends BaseAdminEntityRepository implements CurrencyRepositoryInterface
{
    protected function getEntity(): string
    {
        return Currency::class;
    }

    public function get(): array
    {
        return $this->entityRepository->findAll();
    }

    public function paginate(BaseQuery $dataDTO): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('c')
                                        ->getQuery();

        return $this->paginator($query, $dataDTO);
    }

    public function findByUuid(Uuid $uuid): ?Currency
    {
        return $this->entityRepository->find($uuid);
    }

    public function save(Currency $currency): void
    {
        $this->entityRepository->getEntityManager()->persist($currency);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Currency $currency): void
    {
        $this->entityRepository->getEntityManager()->remove($currency);
        $this->entityRepository->getEntityManager()->flush();
    }
}
