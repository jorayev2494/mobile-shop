<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Infrastructure\Doctrine\Customer;

use App\Repositories\Base\Doctrine\BaseClientEntityRepository;
use Project\Domains\Client\Delivery\Domain\Customer\Customer;
use Project\Domains\Client\Delivery\Domain\Customer\CustomerRepositoryInterface;
use Project\Domains\Client\Delivery\Domain\Customer\ValueObjects\Uuid;

final class CustomerRepository extends BaseClientEntityRepository implements CustomerRepositoryInterface
{
    protected function getEntity(): string
    {
        return Customer::class;
    }

    public function findByUuid(Uuid $uuid): ?Customer
    {
        return $this->entityRepository->find($uuid);
    }

    public function save(Customer $client): void
    {
        $this->entityRepository->getEntityManager()->persist($client);
        $this->entityRepository->getEntityManager()->flush();
    }
}
