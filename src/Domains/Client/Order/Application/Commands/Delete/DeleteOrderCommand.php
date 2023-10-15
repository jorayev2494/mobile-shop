<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Commands\Delete;

use Project\Shared\Domain\Bus\Command\CommandInterface;

final class DeleteOrderCommand implements CommandInterface
{
    public function __construct(
        public readonly string $uuid,
    )
    {
        
    }
}
