<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Infrastructure;
use Illuminate\Support\ServiceProvider;
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
    }
}
