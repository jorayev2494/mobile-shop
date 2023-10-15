<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Infrastructure\Doctrine\Currency;

use App\Repositories\Base\Doctrine\BaseClientEntityRepository;
use Project\Domains\Client\Order\Domain\Currency\Currency;
use Project\Domains\Client\Order\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Client\Order\Domain\Currency\ValueObjects\Uuid;

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
