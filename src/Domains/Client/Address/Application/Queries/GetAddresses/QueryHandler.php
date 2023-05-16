<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Application\Queries\GetAddresses;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class QueryHandler implements \Project\Shared\Domain\Bus\Query\QueryHandler
{
    public function __construct(
        private readonly QueryService $queryService,
    )
    {
        
    }

    public function __invoke(Query $query): LengthAwarePaginator
    {
        return $this->queryService->execute($query);
    }
}
