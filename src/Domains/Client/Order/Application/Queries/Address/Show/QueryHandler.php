<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Queries\Address\Show;

use Project\Domains\Client\Order\Domain\Address\Address;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

final class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly QueryService $service,
    ) {

    }

    public function __invoke(Query $query): Address
    {
        return $this->service->execute($query);
    }
}
