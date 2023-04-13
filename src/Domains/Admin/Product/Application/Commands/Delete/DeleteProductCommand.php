<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Commands\Delete;

use Project\Shared\Domain\Bus\Command\Command;

final class DeleteProductCommand implements Command
{
    public function __construct(
        public readonly string $uuid
    )
    {
        
    }
}
