<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Domain\OrderProduct;

interface OrderProductRepositoryInterface
{
    public function delete(OrderProduct $cartProduct): void;
}
