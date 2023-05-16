<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Base\BaseModelRepository;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductRepository extends BaseModelRepository implements ProductRepositoryInterface
{
    public function getModel(): string
    {
        return Product::class;
    }
}
