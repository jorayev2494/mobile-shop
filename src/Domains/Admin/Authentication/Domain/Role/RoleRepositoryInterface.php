<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Domain\Role;

use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Admin\Authentication\Domain\Role\ValueObjects\Id;
use Project\Shared\Application\Query\BaseQuery;

interface RoleRepositoryInterface
{
    public function findById(int $id): ?Role;

    public function paginate(BaseQuery $queryData): Paginator;

    public function save(Role $role): void;

    public function delete(Role $role): void;
}