<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Commands\Update;

use Project\Shared\Domain\Bus\Command\CommandInterface;

final class UpdateRoleCommand implements CommandInterface
{
    public function __construct(
        public readonly int $id,
        public readonly string $value,
        public readonly array $permissions,
        public readonly bool $isActive,
    )
    {
        
    }
}
