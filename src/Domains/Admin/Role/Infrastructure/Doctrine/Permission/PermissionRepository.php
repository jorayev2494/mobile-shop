<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Infrastructure\Doctrine\Permission;

use App\Repositories\Base\Doctrine\BaseAdminEntityRepository;
use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Admin\Role\Domain\Permission\Permission;
use Project\Domains\Admin\Role\Domain\Permission\PermissionRepositoryInterface;
use Project\Shared\Application\Query\BaseQuery;

final class PermissionRepository extends BaseAdminEntityRepository implements PermissionRepositoryInterface
{
    public function getEntity(): string
    {
        return Permission::class;
    }

    public function paginate(BaseQuery $queryData): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('p')
                                        ->getQuery();

        return $this->paginator($query, $queryData);
    }


    public function findManyByIds(iterable $ids): array
    {
        return $this->entityRepository->createQueryBuilder('p')
                                    ->where('p.id IN (:ids)')
                                    ->setParameter('ids', $ids)
                                    ->getQuery()
                                    ->getResult();
    }

    public function save(Permission $permission): void
    {
        $this->entityRepository->getEntityManager()->persist($permission);
        $this->entityRepository->getEntityManager()->flush();
    }
}
