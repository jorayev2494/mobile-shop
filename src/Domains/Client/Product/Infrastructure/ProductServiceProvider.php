<?php

declare(strict_types=1);

namespace Project\Domains\Client\Product\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Project\Domains\Client\Product\Domain\ProductRepositoryInterface;
use Project\Domains\Client\Product\Infrastructure\Eloquent\ProductRepository;

final class ProductServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    }
}
