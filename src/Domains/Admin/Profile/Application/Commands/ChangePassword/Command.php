<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Application\Commands\ChangePassword;

use Project\Shared\Domain\Bus\Command\CommandInterface;

final class Command implements CommandInterface
{
    public function __construct(
        public readonly string $currentPassword,
        public readonly string $password,
    )
    {
        
    }
}
