<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Commands\Create;

use Project\Domains\Admin\Product\Domain\Product;
use Project\Domains\Admin\Product\Domain\ValueObjects\ProductUUID;
use Project\Domains\Admin\Product\Domain\ValueObjects\ProductCategoryUUID;
use Project\Domains\Admin\Product\Domain\ValueObjects\ProductCurrencyUUID;
use Project\Domains\Admin\Product\Domain\ValueObjects\ProductDiscountPercentage;
use Project\Domains\Admin\Product\Domain\ValueObjects\ProductPrice;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class CreateProductCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CreateProductService $service,
    )
    {

    }

    public function __invoke(CreateProductCommand $command): void
    {
        $product = Product::create(
            ProductUUID::fromValue($command->uuid),
            $command->title,
            ProductCategoryUUID::fromValue($command->categoryUUID),
            ProductCurrencyUUID::fromValue($command->currencyUUID),
            ProductPrice::fromValue($command->price),
            ProductDiscountPercentage::fromValue($command->discountPercentage),
            $command->medias,
            $command->description,
            $command->isActive,
        );

        $this->service->execute($product);
    }
}
