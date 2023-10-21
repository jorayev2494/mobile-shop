<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Commands\Roles\Update;

use Project\Shared\Domain\Bus\Command\CommandInterface;

final class Command implements CommandInterface
{
    public function __construct(
        public readonly int $id,
        public readonly string $value,
        public readonly array $permissions,
    ) {

    }
}
