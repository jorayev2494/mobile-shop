<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Order\Domain;

use App\Repositories\Contracts\BaseModelRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Project\Domains\Admin\Order\Application\Queries\Get\GetOrdersQuery;
use Project\Domains\Admin\Order\Domain\ValueObjects\OrderUUID;

interface OrderRepositoryInterface extends BaseModelRepositoryInterface
{
    public function find(OrderUUID $uuid): ?Order;
    public function paginateByStatus(GetOrdersQuery $queryData, iterable $columns = ['*']): LengthAwarePaginator;
    public function save(Order $order): void;
}
