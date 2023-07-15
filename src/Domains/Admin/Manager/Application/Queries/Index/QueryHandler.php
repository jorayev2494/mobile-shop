<?php

namespace Project\Domains\Admin\Manager\Application\Queries\Index;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Project\Domains\Admin\Manager\Domain\ManagerRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

final class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly ManagerRepositoryInterface $repository,
    )
    {
        
    }

    public function __invoke(Query $query): LengthAwarePaginator
    {
        return $this->repository->indexPaginate($query);
    }
}
