<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Infrastructure\Eloquent;
use App\Repositories\Base\BaseModelRepository;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Project\Domains\Client\Order\Domain\Order;
use Project\Domains\Client\Order\Domain\OrderRepositoryInterface;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderClientUUID;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderUUID;
use Project\Shared\Application\Query\BaseQuery;

final class OrderRepository extends BaseModelRepository implements OrderRepositoryInterface
{
    public function getModel(): string
    {
        return \App\Models\Order::class;
    }

    public function save(Order $order): bool
    {
        return (bool) $this->getModelClone()->newQuery()->updateOrCreate(
            [
                'uuid' => $order->uuid->value,
            ],
            $order->toArray()
        );
    }

    public function getClientOrdersPaginate(OrderClientUUID $clientUuid, BaseQuery $queryData): LengthAwarePaginator
    {
        /** @var Builder $build */
        $query = $this->getModelClone()->newQuery();
        $query->where('client_uuid', $clientUuid->value);

        $this->search($queryData, $query)
            ->sort($queryData, $query)
            ->filters($queryData, $query);

        return $query->paginate($queryData->per_page);
    }

    public function find(OrderUUID $uuid, array $columns = ['*']): ?Model
    {
        return $this->getModelClone()->newQuery()
                                    ->with(['products'])
                                    ->find($uuid->value);
    }

    public function delete(\App\Models\Order $order): void
    {
        $order->products()->detach();
        $order->delete();
    }
}
