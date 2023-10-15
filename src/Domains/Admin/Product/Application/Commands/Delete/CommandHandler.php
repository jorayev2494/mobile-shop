<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Commands\Delete;

use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductUuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly DeleteProductService $service,
    ) {

    }

    public function __invoke(Command $command): void
    {
        $productUuid = ProductUuid::fromValue($command->uuid);

        $this->service->execute($productUuid);
    }
}
