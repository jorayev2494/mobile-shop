<?php

namespace Project\Domains\Admin\Role\Domain;

use App\Repositories\Base\Doctrine\Paginator;
use App\Repositories\Contracts\BaseEntityRepositoryInterface;
use Project\Domains\Admin\Role\Domain\ValueObjects\RoleId;
use Project\Shared\Application\Query\BaseQuery;

interface RoleRepositoryInterface extends BaseEntityRepositoryInterface
{
    public function findById(int $id): ?Role;

    public function paginate(BaseQuery $queryData): Paginator;

    public function save(Role $role): void;
    public function delete(Role $role): void;
}
