<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Infrastructure\Eloquent;

use App\Repositories\Base\BaseModelRepository;
use Project\Domains\Client\Cart\Domain\Product\Product;
use Project\Domains\Client\Cart\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\ProductUUID;

class ProductRepository extends BaseModelRepository implements ProductRepositoryInterface
{
    public function getModel(): string
    {
        return \App\Models\Product::class;
    }

    public function findByUuid(ProductUUID $uuid): ?Product
    {
        /** @var \App\Models\Product $fProduct */
        $fProduct = $this->getModelClone()->newQuery()->find($uuid->value);

        if ($fProduct === null) {
            return null;
        }

        $product = Product::fromPrimitives(
            $fProduct->uuid,
            $fProduct->title,
            $fProduct->category_uuid,
            $fProduct->currency_uuid,
            (string) $fProduct->price,
            (string) $fProduct->discount_percentage,
            $fProduct->viewed_count,
        );

        return $product;
    }
}
