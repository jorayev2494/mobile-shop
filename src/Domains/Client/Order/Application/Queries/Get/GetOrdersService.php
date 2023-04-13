<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Queries\Get;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Project\Domains\Client\Order\Domain\OrderRepositoryInterface;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderUUID;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class GetOrdersService
{
    public function __construct(
        private readonly OrderRepositoryInterface $repository,
        private readonly AuthManagerInterface $authManager,
    )
    {
        
    }

    public function execute(GetOrdersQuery $query): LengthAwarePaginator
    {
        $orderUUID = OrderUUID::fromValue($this->authManager->client()->uuid);

        return $this->repository->getClientOrdersPaginate($orderUUID, $query);
    }
}
