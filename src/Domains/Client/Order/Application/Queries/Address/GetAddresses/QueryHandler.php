<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Queries\Address\GetAddresses;

use Illuminate\Contracts\Support\Arrayable;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

final class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly QueryService $queryService,
    ) {

    }

    public function __invoke(Query $query): array
    {
        return array_map(
            static fn (Arrayable $address): array => $address->toArray(),
            $this->queryService->execute($query)
        );
    }
}
