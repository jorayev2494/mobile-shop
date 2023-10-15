<?php

declare(strict_types=1);

namespace Project\Domains\Client\Card\Application\Commands\Delete;

use Project\Shared\Domain\Bus\Command\CommandInterface;

final class Command implements CommandInterface
{
    public function __construct(
        public readonly string $uuid,
    )
    {
        
    }
}
