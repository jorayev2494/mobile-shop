<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Domain;

use App\Repositories\Contracts\BaseModelRepositoryInterface;
use Project\Domains\Admin\Product\Domain\ValueObjects\ProductUUID;

interface ProductRepositoryInterface extends BaseModelRepositoryInterface
{
    public function save(Product $product): bool;
    public function delete(ProductUUID $uuid): void;
}
