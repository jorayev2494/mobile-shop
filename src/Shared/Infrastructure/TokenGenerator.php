<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure;

use Project\Shared\Domain\TokenGeneratorInterface;

final class TokenGenerator implements TokenGeneratorInterface
{
    public function generate(): string
    {
        return md5((string) microtime(true));
    }
}
