<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Domain\Product;
use App\Repositories\Contracts\BaseModelRepositoryInterface;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\ProductUUID;

interface ProductRepositoryInterface extends BaseModelRepositoryInterface
{
    public function findByUuid(ProductUUID $uuid): ?Product;
}
