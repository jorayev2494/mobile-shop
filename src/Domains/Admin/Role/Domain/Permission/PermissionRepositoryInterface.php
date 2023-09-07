<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Domain\Permission;

use App\Repositories\Base\Doctrine\Paginator;
use App\Repositories\Contracts\BaseEntityRepositoryInterface;
use Project\Shared\Application\Query\BaseQuery;

interface PermissionRepositoryInterface extends BaseEntityRepositoryInterface
{
    public function paginate(BaseQuery $queryData): Paginator;

    /**
     * @param iterable $ids
     * @return array<array-key, Permission>
     */
    public function findManyByIds(iterable $ids): array;

    public function save(Permission $permission): void;
}
