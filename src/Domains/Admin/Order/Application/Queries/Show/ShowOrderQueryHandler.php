<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Order\Application\Queries\Show;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Order\Domain\Order\OrderRepositoryInterface;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;
use Project\Shared\Domain\DomainException;

final class ShowOrderQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly OrderRepositoryInterface $repository,
    ) {

    }

    public function __invoke(ShowOrderQuery $query): object
    {
        $order = $this->repository->findByUuid(Uuid::fromValue($query->uuid));

        if ($order === null) {
            throw new DomainException('Order not found');
        }

        return $order;
    }
}
