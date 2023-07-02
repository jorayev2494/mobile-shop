<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Queries\GetRoles;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Project\Domains\Admin\Role\Domain\RoleRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

class GetRolesQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly RoleRepositoryInterface $repository,
    )
    {
        
    }

    public function __invoke(GetRolesQuery $query): LengthAwarePaginator
    {
        return $this->repository->paginate($query);
    }
}
