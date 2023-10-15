<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Infrastructure\Doctrine\Client;

use App\Repositories\Base\Doctrine\BaseClientEntityRepository;
use Project\Domains\Client\Order\Domain\Client\Client;
use Project\Domains\Client\Order\Domain\Client\ClientRepositoryInterface;
use Project\Domains\Client\Order\Domain\Client\ValueObjects\Uuid;

final class ClientRepository extends BaseClientEntityRepository implements ClientRepositoryInterface
{
    protected function getEntity(): string
    {
        return Client::class;
    }

    public function findByUuid(Uuid $uuid): ?Client
    {
        return $this->entityRepository->find($uuid);
    }

    public function save(Client $client): void
    {
        $this->entityRepository->getEntityManager()->persist($client);
        $this->entityRepository->getEntityManager()->flush();
    }
}
