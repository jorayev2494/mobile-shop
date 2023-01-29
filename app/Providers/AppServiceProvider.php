<?php

namespace App\Providers;

use App\Http\Controllers\Api\Admin\Auth\AuthController;
use App\Services\Api\Auth\AuthService;
use App\Services\Api\Contracts\AuthService as ContractAuthService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->when(AuthController::class)
                    ->needs(ContractAuthService::class)
                    ->give(static fn (): AuthService => resolve(AuthService::class));

        $this->app->bind(
            \App\Services\Api\Contracts\ProfileService::class,
            static fn (): \App\Services\Api\ProfileService => new \App\Services\Api\ProfileService()
        );
    }

    public function boot(): void
    {
        //
    }
}
