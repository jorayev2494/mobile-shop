<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Queries\Find;

use Project\Domains\Client\Order\Domain\ValueObjects\OrderUUID;
use Project\Shared\Domain\Bus\Query\QueryHandler;

final class FindOrderQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly FindOrderService $service
    )
    {
        
    }

    public function __invoke(FindOrderQuery $query): object
    {
        return $this->service->execute(OrderUUID::fromValue($query->uuid));
    }
}
