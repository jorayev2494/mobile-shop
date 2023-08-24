<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Application\Delete;

use Project\Shared\Domain\Bus\Command\CommandInterface;

class Command implements CommandInterface
{
    public function __construct(
        public readonly string $uuid,
    )
    {
        
    }
}
