<?php

declare(strict_types=1);

namespace Project\Domains\Client\Product\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Project\Domains\Client\Product\Application\Queries\Find\FindProductQueryHandler;
use Project\Domains\Client\Product\Application\Queries\Get\GetProductsQueryHandler;
use Project\Domains\Client\Product\Domain\ProductRepositoryInterface;
use Project\Domains\Client\Product\Infrastructure\Eloquent\ProductRepository;

final class ProductServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);

        $this->app->tag(GetProductsQueryHandler::class, 'query_handler');
        $this->app->tag(FindProductQueryHandler::class, 'query_handler');
    }
}
