<?php

declare(strict_types=1);

namespace Project\Shared\Domain;

interface PasswordHasherInterface
{
    public function hash(string $value): string;
}
