<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Domain\Product;

use Project\Domains\Client\Favorite\Domain\Product\ValueObjects\ProductUUID;

class Product
{
    public function __construct(
        private readonly ProductUUID $uuid,
    )
    {
        
    }
}
