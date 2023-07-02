<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Permission\Application\Queries\Index;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Project\Domains\Admin\Permission\Domain\PermissionRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

final class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly PermissionRepositoryInterface $repository,
    )
    {
        
    }

    public function __invoke(Query $query): LengthAwarePaginator
    {
        return $this->repository->paginate($query);
    }
}
