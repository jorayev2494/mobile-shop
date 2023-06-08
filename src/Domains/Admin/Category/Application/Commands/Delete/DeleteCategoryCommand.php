<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Category\Application\Commands\Delete;

use Project\Shared\Application\Command\Command;
use Project\Shared\Domain\Bus\Command\CommandInterface;

final class DeleteCategoryCommand extends Command implements CommandInterface
{
    public function __construct(
        public readonly string $uuid
    )
    {
        
    }
}
