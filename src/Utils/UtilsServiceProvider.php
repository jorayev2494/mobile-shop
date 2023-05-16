<?php

declare(strict_types=1);

namespace Project\Utils;

use Illuminate\Support\ServiceProvider;
use Project\Utils\Auth\AuthManager;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class UtilsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AuthManagerInterface::class, AuthManager::class);
    }
}
