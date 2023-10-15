<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Application\Commands\Operator;

use Project\Shared\Domain\Bus\Command\CommandInterface;

final class Command implements CommandInterface
{
    public function __construct(
        public readonly string $productUuid,
        public readonly string $operator,
        public readonly string $operatorValue,
    ) {

    }
}
