<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Queries\Roles\ShowRole;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Authentication\Domain\Role\Role;
use Project\Domains\Admin\Authentication\Domain\Role\RoleRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

final class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly RoleRepositoryInterface $repository
    ) {

    }

    public function __invoke(Query $query): Role
    {
        $role = $this->repository->findById($query->id);

        if ($role === null) {
            throw new ModelNotFoundException();
        }

        return $role;
    }
}
