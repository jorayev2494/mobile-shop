<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Infrastructure\Doctrine\Address;

use App\Repositories\Base\Doctrine\BaseClientEntityRepository;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\Uuid;
use Project\Domains\Client\Order\Domain\Address\Address;
use Project\Domains\Client\Order\Domain\Address\AddressRepositoryInterface;

final class AddressRepository extends BaseClientEntityRepository implements AddressRepositoryInterface
{
    protected function getEntity(): string
    {
        return Address::class;
    }

    public function findByUuid(Uuid $uuid): ?Address
    {
        return $this->entityRepository->find($uuid->value);
    }

    public function save(Address $address): void
    {
        $this->entityRepository->getEntityManager()->persist($address);
        $this->entityRepository->getEntityManager()->flush();
    }
    public function delete(Address $address): void
    {
        $this->entityRepository->getEntityManager()->remove($address);
        $this->entityRepository->getEntityManager()->flush();
    }
}
