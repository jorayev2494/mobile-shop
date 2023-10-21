<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Doctrine\Role;

use App\Repositories\Base\Doctrine\BaseAdminEntityRepository;
use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Admin\Authentication\Domain\Role\Role;
use Project\Domains\Admin\Authentication\Domain\Role\RoleRepositoryInterface;
use Project\Domains\Admin\Authentication\Domain\Role\ValueObjects\Id;
use Project\Shared\Application\Query\BaseQuery;

final class RoleRepository extends BaseAdminEntityRepository implements RoleRepositoryInterface
{
    protected function getEntity(): string
    {
        return Role::class;
    }

    public function findById(int $id): ?Role
    {
        return $this->entityRepository->find($id);
    }

    public function paginate(BaseQuery $queryData): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('r')
                                        ->getQuery();

        return $this->paginator($query, $queryData);
    }

    public function save(Role $role): void
    {
        $this->entityRepository->getEntityManager()->persist($role);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Role $role): void
    {
        $this->entityRepository->getEntityManager()->remove($role);
        $this->entityRepository->getEntityManager()->flush();
    }
}
