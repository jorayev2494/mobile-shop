<?php

declare(strict_types=1);

namespace Project\Domains\Client\Card\Application\Commands\Update;

use Project\Shared\Domain\Bus\Command\CommandInterface;

final class Command implements CommandInterface
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $type,
        public readonly string $holderName,
        public readonly string $number,
        public readonly int $cvv,
        public readonly string $expirationDate,
    ) {

    }
}
