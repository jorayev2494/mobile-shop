<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Queries\GetPermissions;

use App\Repositories\Base\Doctrine\Paginator;
use Illuminate\Support\Collection;
use Project\Domains\Admin\Role\Domain\Permission\PermissionRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

final class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly PermissionRepositoryInterface $permissionRepository,
    )
    {
        
    }

    public function __invoke(Query $query): Collection
    {
        return Collection::make($this->permissionRepository->get($query));
    }
}
