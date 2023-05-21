<?php

declare(strict_types=1);

namespace Project\Shared\Domain;

interface UuidGeneratorInterface
{
    public function generate(): string;
}
