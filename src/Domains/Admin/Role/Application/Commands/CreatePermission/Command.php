<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Commands\CreatePermission;

use Project\Shared\Domain\Bus\Command\CommandInterface;

final class Command implements CommandInterface
{
    public function __construct(
        public readonly string $subject,
        public readonly string $action,
    ) {

    }
}
