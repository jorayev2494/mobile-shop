<?php

declare(strict_types=1);

namespace Project\Shared\Domain;

interface TokenGeneratorInterface
{
    public function generate(): string;
}
