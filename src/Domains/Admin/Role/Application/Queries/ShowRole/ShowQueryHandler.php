<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Queries\ShowRole;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Role\Domain\Role;
use Project\Domains\Admin\Role\Domain\RoleRepositoryInterface;
use Project\Domains\Admin\Role\Domain\ValueObjects\RoleId;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

final class ShowQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly RoleRepositoryInterface $repository
    )
    {

    }

    public function __invoke(ShowQuery $query): Role
    {
        $role = $this->repository->findById(RoleId::fromValue($query->id));

        if ($role === null) {
            throw new ModelNotFoundException();
        }

        return $role;
    }
}
