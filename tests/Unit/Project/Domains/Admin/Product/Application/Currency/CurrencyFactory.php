<?php

declare(strict_types=1);

namespace Tests\Unit\Project\Domains\Admin\Product\Application\Currency;

use Project\Domains\Admin\Product\Domain\Currency\Currency;

class CurrencyFactory
{
    public const UUID = '1f00e8dd-978c-41a6-89b4-ee634a8daef8';

    public const CURRENCY = 'USD';

    public const IS_ACTIVE = true;

    public static function make(string $uuid = self::UUID, string $currency = self::CURRENCY, bool $isActive = self::IS_ACTIVE): Currency
    {
        return Currency::fromPrimitives($uuid, $currency, $isActive);
    }
}
