<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Domain\Permission;

use App\Repositories\Base\Doctrine\Paginator;
use Doctrine\Common\Collections\Collection;
use Project\Shared\Application\Query\BaseQuery;

interface PermissionRepositoryInterface
{
    public function get(BaseQuery $queryData): array;
    public function paginate(BaseQuery $queryData): Paginator;

    /**
     * @param iterable $ids
     * @return array<array-key, Permission>
     */
    public function findManyByIds(iterable $ids): array;

    public function save(Permission $permission): void;
}
