<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Category\Application\Commands\Create;

use Project\Shared\Application\Command\Command;

final class CreateCategoryCommand extends Command
{
    public function __construct(
        public readonly string $value,
        public readonly bool $isActive,
    )
    {
        
    }
}
