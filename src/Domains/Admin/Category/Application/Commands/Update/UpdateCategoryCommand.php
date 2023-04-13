<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Category\Application\Commands\Update;

use Project\Shared\Application\Command\Command;

final class UpdateCategoryCommand extends Command
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $value,
        public readonly bool $isActive,
    )
    {
        
    }
}
