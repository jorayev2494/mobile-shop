<?php

namespace App\Providers;

use App\Models\Enums\AppGuardType;
use App\Repositories\CategoryRepository;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Repositories\RoleRepository;
use App\Services\Api\Admin\CategoryService;
use App\Services\Api\Admin\Contracts\CategoryServiceInterface;
use App\Services\Api\Admin\Contracts\ProductServiceInterface;
use App\Services\Api\Admin\Contracts\RoleServiceInterface;
use App\Services\Api\Admin\ProductService;
use App\Services\Api\Admin\RoleService;
use App\Services\Api\Auth\AuthService;
use App\Services\Api\Contracts\AuthService as ContractAuthService;
use Illuminate\Support\ServiceProvider;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Project\Shared\Infrastructure\Bus\Messenger\MessengerEventBus;
use Project\Shared\Infrastructure\Bus\Messenger\MessengerQueryBus;
use Project\Shared\Infrastructure\Bus\Messenger\MessengerCommandBus;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerBuses();

        $this->app->when(\App\Http\Controllers\Api\Admin\Auth\AuthController::class)
                    ->needs(ContractAuthService::class)
                    ->give(static fn (): AuthService => resolve(AuthService::class, ['guard' => AppGuardType::ADMIN]));

        $this->app->when(\App\Http\Controllers\Api\Client\Auth\AuthController::class)
                    ->needs(ContractAuthService::class)
                    ->give(static fn (): AuthService => resolve(AuthService::class, ['guard' => AppGuardType::CLIENT]));

        $this->app->bind(ContractAuthService::class, AuthService::class);

        $this->app->bind(\App\Services\Api\Contracts\ProfileService::class, \App\Services\Api\ProfileService::class
        );

        // Services
        $this->app->bind(RoleServiceInterface::class, RoleService::class);
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);

        // Repositories
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    }

    public function boot(): void
    {
        //
    }

    private function registerBuses(): void
    {
        $this->app->bind(
            EventBusInterface::class,
            static fn (\Illuminate\Contracts\Foundation\Application $app): MessengerEventBus => new MessengerEventBus($app->tagged('domain_event_subscriber'))
        );

        $this->app->bind(
            QueryBusInterface::class,
            static fn (\Illuminate\Contracts\Foundation\Application $app): MessengerQueryBus => new MessengerQueryBus($app->tagged('query_handler'))
        );

        $this->app->bind(
            CommandBusInterface::class,
            static fn (\Illuminate\Contracts\Foundation\Application $app): MessengerCommandBus => new MessengerCommandBus($app->tagged('command_handler'))
        );
    }
}
