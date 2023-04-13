<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Commands\Delete;

use Project\Shared\Application\Command\Command;

final class DeleteRoleCommand extends Command
{
    public function __construct(
        public readonly int $id,
    )
    {
        
    }
}
