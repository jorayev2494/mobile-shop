<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Infrastructure\Doctrine\Manager;

use App\Repositories\Base\Doctrine\BaseAdminEntityRepository;
use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Admin\Manager\Domain\Manager\Manager;
use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerUuid;
use Project\Shared\Application\Query\BaseQuery;

final class ManagerRepository extends BaseAdminEntityRepository implements ManagerRepositoryInterface
{
    protected function getEntity(): string
    {
        return Manager::class;
    }

    public function paginate(BaseQuery $queryDTO): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('m')
                                        ->getQuery();

        return $this->paginator($query, $queryDTO);
    }

    public function findByUuid(ManagerUuid $uuid): ?Manager
    {
        return $this->entityRepository->find($uuid->value);
    }

    public function save(Manager $manager): void
    {
        $this->entityRepository->getEntityManager()->persist($manager);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Manager $manager): void
    {
        $this->entityRepository->getEntityManager()->remove($manager);
        $this->entityRepository->getEntityManager()->flush();
    }
}
