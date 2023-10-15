<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Order\Domain\Order;

use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Admin\Order\Application\Queries\Get\GetOrdersQuery;
use Project\Domains\Client\Order\Domain\Order\Order;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Uuid;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\StatusEnum;
use Project\Shared\Application\Query\BaseQuery;

interface OrderRepositoryInterface
{
    public function findByUuid(Uuid $uuid): ?Order;

    public function paginateByStatus(BaseQuery $queryData, ?StatusEnum $status): Paginator;

    public function save(Order $order): void;
}
