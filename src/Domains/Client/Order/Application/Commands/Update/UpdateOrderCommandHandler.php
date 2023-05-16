<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Commands\Update;

use Project\Shared\Domain\Bus\Command\CommandHandler;

final class UpdateOrderCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly UpdateOrderService $service,
    )
    {
        
    }

    public function __invoke(UpdateOrderCommand $command): array
    {
        return $this->service->execute($command);
    }
}
