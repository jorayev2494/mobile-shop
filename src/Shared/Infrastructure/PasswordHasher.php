<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure;

use Illuminate\Support\Facades\Hash;
use Project\Shared\Domain\PasswordHasherInterface;

final class PasswordHasher implements PasswordHasherInterface
{
    public function hash(string $value): string
    {
        return bcrypt($value);
    }

    public function check(string $password, string $hashedPassword): bool
    {
        return Hash::check($password, $hashedPassword);
    }
}
