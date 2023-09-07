<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure;

use Project\Shared\Domain\PasswordHasherInterface;

final class PasswordHasher implements PasswordHasherInterface
{
    public function hash(string $value): string
    {
        return bcrypt($value);
    }
}
