<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Domain;

use App\Repositories\Contracts\BaseModelRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderUUID;
use Project\Shared\Application\Query\BaseQuery;

interface OrderRepositoryInterface extends BaseModelRepositoryInterface
{
    public function save(Order $order): bool;
    public function getClientOrdersPaginate(OrderUUID $uuid, BaseQuery $queryData): LengthAwarePaginator;
    public function find(OrderUUID $uuid, array $columns = ['*']): ?Model;
    public function delete(\App\Models\Order $order): void;
}
