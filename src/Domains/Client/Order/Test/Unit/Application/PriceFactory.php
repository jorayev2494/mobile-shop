<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Test\Unit\Application;

use Project\Domains\Client\Order\Domain\Currency\Currency;
use Project\Domains\Client\Order\Domain\Product\ValueObjects\Price;

class PriceFactory
{
    public const PRICE = 299.99;

    public const DISCOUNT_PERCENTAGE = 10;

    public static function make(
        float $price = null,
        int $discountPercentage = null,
        Currency $currency = null,
    ): Price
    {
        return new Price(
            $price ?? self::PRICE,
            $discountPercentage ?? self::DISCOUNT_PERCENTAGE,
            $currency ?? CurrencyFactory::UUID,
        );
    }
}
