<?php

declare(strict_types=1);

namespace Project\Domains\Client\Product\Infrastructure\Eloquent;

use App\Repositories\Base\BaseModelRepository;
use Project\Domains\Client\Product\Domain\ProductRepositoryInterface;

final class ProductRepository extends BaseModelRepository implements ProductRepositoryInterface
{
    public function getModel(): string
    {
        return \App\Models\Product::class;
    }
}