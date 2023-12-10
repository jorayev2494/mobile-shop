<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Infrastructure\Doctrine\Address;

use App\Repositories\Base\Doctrine\BaseClientEntityRepository;
use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\AuthorUuid;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\Uuid;
use Project\Domains\Client\Order\Domain\Address\Address;
use Project\Domains\Client\Order\Domain\Address\AddressRepositoryInterface;
use Project\Shared\Application\Query\BaseQuery;

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

    public function getByAuthorUuid(AuthorUuid $uuid, BaseQuery $query): array
    {
        return $this->entityRepository->createQueryBuilder('a')
            ->where('a.authorUuid = :authorUuid')
            ->setParameter('authorUuid', $uuid)
            ->getQuery()
            ->getResult();
    }

    public function paginateByAuthorUuid(AuthorUuid $uuid, BaseQuery $queryData): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('a')
            ->where('a.authorUuid = :authorUuid')
            ->setParameter('authorUuid', $uuid)
            ->getQuery();

        return $this->paginator($query, $queryData);
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
