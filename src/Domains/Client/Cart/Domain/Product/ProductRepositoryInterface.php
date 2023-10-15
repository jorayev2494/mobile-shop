<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Domain\Product;

use Project\Domains\Client\Cart\Domain\Product\ValueObjects\Uuid as ProductUuid;

interface ProductRepositoryInterface
{
    public function findByUuid(ProductUuid $uuid): ?Product;
    public function save(Product $product): void;
    public function delete(Product $product): void;
}
