<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Application\Queries\Index;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Project\Domains\Admin\Country\Domain\CountryRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

final class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly CountryRepositoryInterface $repository,
    )
    {
        
    }

    public function __invoke(Query $query): LengthAwarePaginator
    {
        return $this->repository->paginate($query);
    }
}
