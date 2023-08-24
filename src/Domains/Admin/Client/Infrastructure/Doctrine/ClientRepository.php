<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Infrastructure\Doctrine;

use App\Repositories\Base\Doctrine\BaseAdminEntityRepository;
use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Admin\Client\Domain\Client\Client;
use Project\Domains\Admin\Client\Domain\Client\ClientRepositoryInterface;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientUuid;
use Project\Shared\Application\Query\BaseQuery;

class ClientRepository extends BaseAdminEntityRepository implements ClientRepositoryInterface
{
    public function getEntity(): string
    {
        return Client::class;
    }

    public function paginate(BaseQuery $dataDTO): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('c')
                                        ->getQuery();

        return $this->paginator($query, $dataDTO);
    }

    public function findByUuid(ClientUuid $uuid): ?Client
    {
        return $this->entityRepository->find($uuid->value);
    }

    public function save(Client $client): void
    {
        $this->entityRepository->getEntityManager()->persist($client);
        $this->entityRepository->getEntityManager()->flush();
    }
    
    public function delete(Client $client): void
    {
        $this->entityRepository->getEntityManager()->remove($client);
        $this->entityRepository->getEntityManager()->flush();
    }
}
