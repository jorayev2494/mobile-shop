<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Infrastructure\Doctrine;

use App\Repositories\Base\Doctrine\BaseClientEntityRepository;
use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Client\Address\Domain\Address;
use Project\Domains\Client\Address\Domain\AddressRepositoryInterface;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressAuthorUuid;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressUuid;
use Project\Shared\Application\Query\BaseQuery;

final class AddressRepository extends BaseClientEntityRepository implements AddressRepositoryInterface
{
    protected function getEntity(): string
    {
        return Address::class;
    }

    public function findByUuid(AddressUuid $uuid): ?Address
    {
        return $this->entityRepository->find($uuid->value);
    }

    public function getByAuthorUuid(AddressAuthorUuid $uuid, BaseQuery $query): array
    {
        return $this->entityRepository->createQueryBuilder('a')
                                    ->where('a.authorUuid = :authorUuid')
                                    ->setParameter('authorUuid', $uuid)
                                    ->getQuery()
                                    ->getResult();
    }

    public function paginateByAuthorUuid(AddressAuthorUuid $uuid, BaseQuery $queryData): Paginator
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
