<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Queries\Roles\GetRoles;

use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Admin\Authentication\Domain\Role\RoleRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly RoleRepositoryInterface $repository,
    ) {

    }

    public function __invoke(Query $query): Paginator
    {
        return $this->repository->paginate($query);
    }
}
