<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Project\Domains\Admin\Product\Application\Commands\Create\CreateProductCommandHandler;
use Project\Domains\Admin\Product\Application\Commands\Delete\DeleteProductCommandHandler;
use Project\Domains\Admin\Product\Application\Commands\Update\UpdateProductCommandHandler;
use Project\Domains\Admin\Product\Application\Queries\Find\FindProductQueryHandler;
use Project\Domains\Admin\Product\Application\Queries\Get\GetProductsQueryHandler;
use Project\Domains\Admin\Product\Application\Subscribers\ProductWasCreatedEventHandler;
use Project\Domains\Admin\Product\Domain\ProductRepositoryInterface;
use Project\Domains\Admin\Product\Infrastructure\Eloquent\ProductRepository;

final class ProductServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // $this->app->bind(
        //     QueryBusInterface::class,
        //     static fn (\Illuminate\Contracts\Foundation\Application $app): MessengerQueryBus => new MessengerQueryBus($app->tagged('query_handler'))
        // );

        // $this->app->bind(
        //     CommandBusInterface::class,
        //     static fn (\Illuminate\Contracts\Foundation\Application $app): MessengerCommandBus => new MessengerCommandBus($app->tagged('command_handler'))
        // );

        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);

        $this->app->tag(CreateProductCommandHandler::class, 'command_handler');
        $this->app->tag(UpdateProductCommandHandler::class, 'command_handler');
        $this->app->tag(DeleteProductCommandHandler::class, 'command_handler');

        $this->app->tag(GetProductsQueryHandler::class, 'query_handler');
        $this->app->tag(FindProductQueryHandler::class, 'query_handler');

        $this->app->tag(ProductWasCreatedEventHandler::class, 'domain_event_subscriber');
    }
}
