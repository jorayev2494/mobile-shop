<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Infrastructure;
use Illuminate\Support\ServiceProvider;
use Project\Domains\Client\Order\Application\Commands\Create\CreateOrderCommandHandler;
use Project\Domains\Client\Order\Application\Commands\Delete\DeleteOrderCommandHandler;
use Project\Domains\Client\Order\Application\Commands\Update\UpdateOrderCommandHandler;
use Project\Domains\Client\Order\Application\Queries\Find\FindOrderQueryHandler;
use Project\Domains\Client\Order\Application\Queries\Get\GetOrdersQueryHandler;
use Project\Domains\Client\Order\Domain\OrderProductRepositoryInterface;
use Project\Domains\Client\Order\Domain\OrderRepositoryInterface;
use Project\Domains\Client\Order\Infrastructure\Eloquent\OrderProductRepository;
use Project\Domains\Client\Order\Infrastructure\Eloquent\OrderRepository;

final class OrderServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(OrderProductRepositoryInterface::class, OrderProductRepository::class);

        // $this->app->tag(GetOrdersQueryHandler::class, 'query_handler');
        // $this->app->tag(FindOrderQueryHandler::class, 'query_handler');

        // $this->app->tag(CreateOrderCommandHandler::class, 'command_handler');
        // $this->app->tag(UpdateOrderCommandHandler::class, 'command_handler');
        // $this->app->tag(DeleteOrderCommandHandler::class, 'command_handler');
    }
}
