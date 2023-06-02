<?php

namespace Project\Domains\Admin\Product\Application\Commands\Update;

use Project\Domains\Admin\Product\Domain\Product;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class UpdateProductCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly UpdateProductService $service,
    )
    {

    }

    public function __invoke(UpdateProductCommand $command): array
    {
        $product = Product::fromPrimitives(
            $command->uuid,
            $command->title,
            $command->categoryUUID,
            $command->currencyUUID,
            $command->price,
            $command->discountPercentage,
            $command->medias,
            0,
            $command->description,
            $command->isActive,
        );

        $this->service->execute($product);

        return ['uuid' => $command->uuid];
    }
}
