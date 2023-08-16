<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Project\Domains\Client\Cart\Application\Commands\AddProduct\CommandHandler as AddProductCommandHandler;
use Project\Domains\Client\Cart\Application\Commands\Create\CommandHandler as CreateCommandHandler;
use Project\Domains\Client\Cart\Application\Commands\DeleteProduct\CommandHandler as DeleteProductCommandHandler;
use Project\Domains\Client\Cart\Application\Queries\Index\QueryHandler as IndexQueryHandler;
use Project\Domains\Client\Cart\Application\Queries\Show\QueryHandler as ShowQueryHandler;
use Project\Domains\Client\Cart\Domain\Cart\CartRepositoryInterface;
use Project\Domains\Client\Cart\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Client\Cart\Infrastructure\Eloquent\CartRepository;
use Project\Domains\Client\Cart\Infrastructure\Eloquent\ProductRepository;

final class CartServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);

        $this->app->tag(IndexQueryHandler::class, 'query_handler');
        $this->app->tag(ShowQueryHandler::class, 'query_handler');

        $this->app->tag(CreateCommandHandler::class, 'command_handler');
        $this->app->tag(AddProductCommandHandler::class, 'command_handler');
        $this->app->tag(DeleteProductCommandHandler::class, 'command_handler');
    }
}
