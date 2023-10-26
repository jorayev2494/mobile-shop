<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Domain\Order;

use App\Repositories\Contracts\BaseModelRepositoryInterface;

interface OrderProductRepositoryInterface extends BaseModelRepositoryInterface
{
    public function save(iterable $orderProducts): bool;
}
