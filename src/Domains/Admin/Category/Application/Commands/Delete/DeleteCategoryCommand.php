<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Category\Application\Commands\Delete;

use Project\Shared\Application\Command\Command;

final class DeleteCategoryCommand extends Command
{
    public function __construct(
        public readonly string $uuid
    )
    {
        
    }
}
