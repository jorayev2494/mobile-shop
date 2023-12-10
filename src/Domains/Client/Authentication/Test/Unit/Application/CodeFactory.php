<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Test\Unit\Application;

use Project\Domains\Client\Authentication\Domain\Code\Code;

class CodeFactory
{
    public const CODE = 102030;

    public const EXPIRATION_DATE = '+ 1 hours';

    public static function make(int $code = null, string $expirationDate = null): Code
    {
        return Code::fromPrimitives(
            $code ?? self::CODE,
            new \DateTimeImmutable($expirationDate ?? self::EXPIRATION_DATE),
        );
    }
}
