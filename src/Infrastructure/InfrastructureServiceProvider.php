<?php

declare(strict_types=1);

namespace Project\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Project\Shared\Domain\Bus\Event\EventBus;
use Project\Infrastructure\Bus\Event\Log\LogEventBus;

final class InfrastructureServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(EventBus::class, LogEventBus::class);   
    }
}
