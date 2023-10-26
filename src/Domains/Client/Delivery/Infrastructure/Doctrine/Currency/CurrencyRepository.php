<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Infrastructure\Doctrine\Currency;

use App\Repositories\Base\Doctrine\BaseClientEntityRepository;
use Project\Domains\Client\Delivery\Domain\Currency\Currency;
use Project\Domains\Client\Delivery\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Client\Delivery\Domain\Currency\ValueObjects\Uuid;

final class CurrencyRepository extends BaseClientEntityRepository implements CurrencyRepositoryInterface
{
    protected function getEntity(): string
    {
        return Currency::class;
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
