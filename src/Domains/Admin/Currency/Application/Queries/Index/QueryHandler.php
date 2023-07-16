<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Currency\Application\Queries\Index;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Project\Domains\Admin\Currency\Domain\CurrencyRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly CurrencyRepositoryInterface $repository,
    )
    {
        
    }

    public function __invoke(Query $query): LengthAwarePaginator
    {
        return $this->repository->paginate($query);
    }
}
