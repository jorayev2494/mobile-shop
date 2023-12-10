<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Domain\Order\ValueObjects;

use Project\Shared\Domain\ValueObject\StringValueObject;

class Number extends StringValueObject
{
    private const PREFIX = 'BFF-';

    public static function generate(): self
    {
        return self::fromValue(self::gen());
    }

    private static function gen(): string
    {
        $today = date('Ymd');
        $rand = strtoupper(substr(uniqid(sha1((string) time())),0,4));

        return self::PREFIX . $today . $rand;
    }
}
