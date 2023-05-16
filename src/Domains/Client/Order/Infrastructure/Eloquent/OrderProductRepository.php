<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Infrastructure\Eloquent;

use App\Repositories\Base\BaseModelRepository;
use Project\Domains\Client\Order\Domain\OrderProduct;
use Project\Domains\Client\Order\Domain\OrderProductRepositoryInterface;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderUUID;

final class OrderProductRepository extends BaseModelRepository implements OrderProductRepositoryInterface
{
    public function getModel(): string
    {
        return \App\Models\OrderProduct::class;
    }

    /**
     * @param iterable<OrderProduct> $orderProducts
     * @return boolean
     */
    public function save(iterable $orderProducts): bool
    {
        foreach ($orderProducts as $key => $orderProduct) {
            $this->getModelClone()->newQuery()->updateOrCreate(
                ['uuid' => $orderProduct->uuid],
                $orderProduct->toArray()
            );
        }

        return true; 
    }
}
