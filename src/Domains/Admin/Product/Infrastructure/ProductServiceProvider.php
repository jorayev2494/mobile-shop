<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Project\Domains\Admin\Product\Domain\ProductRepositoryInterface;
use Project\Domains\Admin\Product\Infrastructure\Eloquent\ProductRepository;

final class ProductServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    }
}
