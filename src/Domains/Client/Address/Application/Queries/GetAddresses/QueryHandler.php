<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Application\Queries\GetAddresses;

use App\Repositories\Base\Doctrine\Paginator;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

final class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly QueryService $queryService,
    )
    {
        
    }

    public function __invoke(Query $query): Paginator
    {
        return $this->queryService->execute($query);
    }
}
