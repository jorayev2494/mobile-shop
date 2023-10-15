<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Order\Application\Commands\Update;

use Project\Shared\Domain\Bus\Command\CommandInterface;

final class Command implements CommandInterface
{
    public function __construct(
        public readonly string $uuid,
        // public readonly ?string $email,
        // public readonly ?string $phone,
        // public readonly string $description,
        public readonly string $status,
    )
    {
        
    }
}
