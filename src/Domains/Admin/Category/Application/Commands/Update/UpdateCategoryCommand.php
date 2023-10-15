<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Category\Application\Commands\Update;

use Project\Shared\Application\Command\Command;
use Project\Shared\Domain\Bus\Command\CommandInterface;

final class UpdateCategoryCommand extends Command implements CommandInterface
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $value,
        public readonly bool $isActive,
    )
    {
        
    }
}
