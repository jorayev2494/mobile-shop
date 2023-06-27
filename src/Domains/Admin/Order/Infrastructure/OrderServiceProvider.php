<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Order\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Project\Domains\Admin\Order\Application\Commands\Update\UpdateOrderCommandHandler;
use Project\Domains\Admin\Order\Application\Queries\Get\GetOrdersQueryHandler;
use Project\Domains\Admin\Order\Application\Queries\Show\ShowOrderQueryHandler;
use Project\Domains\Admin\Order\Domain\OrderRepositoryInterface;
use Project\Domains\Admin\Order\Infrastructure\Eloquent\OrderRepository;

final class OrderServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);

        $this->app->tag(UpdateOrderCommandHandler::class, 'command_handler');

        $this->app->tag(GetOrdersQueryHandler::class, 'query_handler');
        $this->app->tag(ShowOrderQueryHandler::class, 'query_handler');
    }
}
