<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Queries\Order\Show;

use Project\Domains\Client\Order\Domain\Order\Order;
use Project\Domains\Client\Order\Domain\Order\OrderRepositoryInterface;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;
use Project\Shared\Domain\DomainException;

final class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly OrderRepositoryInterface $repository,
    ) {

    }

    public function __invoke(Query $query): Order
    {
        $order = $this->repository->findByUuid(Uuid::fromValue($query->uuid));

        $order ?? throw new DomainException('Order not found');

        return $order;
    }
}
