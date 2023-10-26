<?php

declare(strict_types=1);

namespace Tests\Unit\Project\Domains\Admin\Product\Application\Product;

use Project\Domains\Admin\Product\Domain\Currency\Currency;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductPrice;
use Tests\Unit\Project\Domains\Admin\Product\Application\Currency\CurrencyFactory;

class PriceFactory
{
    public const PRICE = 299.99;

    public const DISCOUNT_PERCENTAGE = 10;

    public static function make(
        float $price = null,
        int $discountPercentage = null,
        Currency $currency = null,
    ): ProductPrice
    {
        return new ProductPrice($price ?? self::PRICE, $discountPercentage ?? self::DISCOUNT_PERCENTAGE, $currency ?? CurrencyFactory::make());
    }
}
