<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Infrastructure\Eloquent;

use App\Repositories\Base\BaseModelRepository;
use Project\Domains\Admin\Product\Domain\Product;
use Project\Domains\Admin\Product\Domain\ProductRepositoryInterface;
use Project\Domains\Admin\Product\Domain\ValueObjects\ProductUUID;

final class ProductRepository extends BaseModelRepository implements ProductRepositoryInterface
{
    public function getModel(): string
    {
        return \App\Models\Product::class;
    }

    public function save(Product $product): bool
    {
        return (bool) $this->getModelClone()->newQuery()->updateOrCreate(
            [
                'uuid' => $product->uuid->value,
            ],
            $product->toArray()
        );
    }

    public function delete(ProductUUID $uuid): void
    {
        $this->getModelClone()->newQuery()->find($uuid->value)->delete();
    }
}