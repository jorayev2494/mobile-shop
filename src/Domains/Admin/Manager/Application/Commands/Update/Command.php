<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Commands\Update;

use Project\Shared\Domain\Bus\Command\CommandInterface;

final class Command implements CommandInterface
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $email,
        public readonly int $roleId,
    )
    {
        
    }
}
