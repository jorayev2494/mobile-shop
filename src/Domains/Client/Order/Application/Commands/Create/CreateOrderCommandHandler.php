<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Commands\Create;

use Project\Shared\Domain\Bus\Command\CommandHandler;

final class CreateOrderCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly CreateOrderService $service,
    )
    {
        
    }

    public function __invoke(CreateOrderCommand $command): array
    {
        return $this->service->execute($command);
    }
}
