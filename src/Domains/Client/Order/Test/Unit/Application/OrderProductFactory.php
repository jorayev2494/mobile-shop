<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Test\Unit\Application;

use Project\Domains\Admin\Product\Test\Unit\Application\Product\ProductFactory;
use Project\Domains\Client\Order\Domain\OrderProduct\OrderProduct;
use Project\Domains\Client\Order\Domain\OrderProduct\ValueObjects\Quantity;
use Project\Domains\Client\Order\Domain\Product\Product;

class OrderProductFactory
{
    public const UUID = 'e898e3fb-d62f-4b51-b1b6-fc4cb5c3bd6d';

    public const ORDER_UUID = OrderFactory::UUID;

    public const PRODUCT_UUID = ProductFactory::UUID;

    public const QUANTITY = 1;

    public const SUM = 29.99;

    public const DISCARD_SUM = 9.99;

    public static function make(
        Product $product = null,
        Quantity $quantity = null,
    ): OrderProduct
    {
        return OrderProduct::make(
            $product ?? \Project\Domains\Client\Order\Test\Unit\Application\ProductFactory::make(),
            $quantity ?? Quantity::fromValue(5),
        );
    }
}
