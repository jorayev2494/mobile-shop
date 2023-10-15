<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure;

use Project\Shared\Domain\CodeGeneratorInterface;

final class CodeGenerator implements CodeGeneratorInterface
{
    public function generate(int $min = 111111, int $max = 999999): int
    {
        return random_int($min, $max);
    }
}
