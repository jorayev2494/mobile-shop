<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Application\Commands\Update;

use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class UpdateOrderCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly UpdateOrderService $service,
    ) {

    }

    public function __invoke(UpdateOrderCommand $command): void
    {
        
    }
}
