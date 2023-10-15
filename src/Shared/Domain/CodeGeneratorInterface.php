<?php

declare(strict_types=1);

namespace Project\Shared\Domain;

interface CodeGeneratorInterface
{
    public function generate(): int;
}
