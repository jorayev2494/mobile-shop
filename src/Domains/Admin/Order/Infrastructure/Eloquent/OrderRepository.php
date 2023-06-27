<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Order\Infrastructure\Eloquent;

use App\Repositories\Base\BaseModelRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Project\Domains\Admin\Order\Application\Queries\Get\GetOrdersQuery;
use Project\Domains\Admin\Order\Domain\Order;
use Project\Domains\Admin\Order\Domain\OrderRepositoryInterface;
use Project\Domains\Admin\Order\Domain\ValueObjects\OrderUUID;

final class OrderRepository extends BaseModelRepository implements OrderRepositoryInterface
{
    public function getModel(): string
    {
        return \App\Models\Order::class;
    }

    public function find(OrderUUID $uuid): ?Order
    {
        /** @var \App\Models\Order|null $foundOrder */
        $foundOrder = $this->getModelClone()->newQuery()->find($uuid->value);

        if ($foundOrder === null) {
            return $foundOrder;
        }

        $order = Order::fromPrimitives(
            $foundOrder->uuid,
            $foundOrder->email,
            $foundOrder->phone,
            $foundOrder->description,
            $foundOrder->status,
            $foundOrder->quality,
            $foundOrder->sum,
            $foundOrder->discard_sum,
            $foundOrder->is_active
        );

        return $order;
    }

    public function paginateByStatus(GetOrdersQuery $queryData, iterable $columns = ['*']): LengthAwarePaginator
    {
        /** @var Builder $build */
        $query = $this->getModelClone()->newQuery();
        $query->select($columns);

        if (! is_null($queryData->status)) {
            $query->where('status', $queryData->status);
        }

        $this->search($queryData, $query)
            ->sort($queryData, $query)
            ->filters($queryData, $query);

        return $query->paginate($queryData->per_page);
    }

    public function save(Order $order): void
    {
        $this->getModelClone()->newQuery()->updateOrCreate(
            ['uuid' => $order->uuid->value],
            [
                'email' => $order->email->value,
                'phone' => $order->phone->value,
                'description' => $order->description->value,
                'status' => $order->status,
            ]
        );
    }
}
