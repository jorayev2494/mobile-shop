<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Test\Unit\Application;

use Project\Domains\Client\Order\Domain\Order\ValueObjects\Meta;

class MetaFactory
{
    public const QUANTITY = 1;

    public const SUM = 19.99;

    public static function make(
        int $quantity = null,
        float $sum = null,
    ): Meta
    {
        return new Meta(
            $quantity ?? self::QUANTITY,
            $sum ?? self::SUM,
        );
    }
}
