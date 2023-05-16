<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Queries\ShowRole;

use Project\Domains\Admin\Role\Domain\RoleRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandler;

final class ShowQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly RoleRepositoryInterface $repository
    )
    {

    }

    public function __invoke(ShowQuery $query): object
    {
        return $this->repository->findOrFail($query->id);
    }
}
