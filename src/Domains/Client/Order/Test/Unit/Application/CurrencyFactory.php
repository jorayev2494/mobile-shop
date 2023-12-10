<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Test\Unit\Application;

use Project\Domains\Client\Order\Domain\Currency\Currency;

class CurrencyFactory
{
    public const UUID = 'f10ba477-4214-4b7f-9e09-f0e16126bb81';

    public const CURRENCY = 'UAH';

    public const IS_ACTIVE = true;

    public static function make(
        string $uuid = null,
        string $value = null,
        bool $isActive = null,
    ): Currency
    {
        return Currency::fromPrimitives(
            $uuid ?? self::UUID,
            $value ?? self::CURRENCY,
            $isActive ?? self::IS_ACTIVE,
        );
    }
}
