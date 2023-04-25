<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Application\Queries\Find;

use Project\Shared\Domain\Bus\Query\QueryHandler;

final class FindAddressQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly FindAddressQueryService $service,
    )
    {
        
    }

    public function __invoke(FindAddressQuery $query): object
    {
        return $this->service->execute($query);
    }
}
