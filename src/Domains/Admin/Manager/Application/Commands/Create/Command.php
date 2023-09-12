<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Commands\Create;

use Project\Shared\Domain\Bus\Command\CommandInterface;

final class Command implements CommandInterface
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $email,
        public readonly int $roleId,
    )
    {
        
    }
}
