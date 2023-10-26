<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Enums\AppGuardType;
use App\Services\Api\Auth\AuthService;
use App\Services\Api\Contracts\AuthService as ContractAuthService;
use Doctrine\Common\Collections\ArrayCollection;
use Illuminate\Support\ServiceProvider;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Project\Shared\Infrastructure\Bus\DomainEventSubscriberLocator;
use Project\Shared\Infrastructure\Bus\Messenger\MessengerQueryBus;
use Project\Shared\Infrastructure\Bus\Messenger\MessengerCommandBus;
use Project\Shared\Infrastructure\Bus\RabbitMQ\Command\CommandHandlerLocator;
use Project\Shared\Infrastructure\Bus\RabbitMQ\Event\RabbitMQEventBus;

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

        $this->app->bind(\App\Services\Api\Contracts\ProfileService::class, \App\Services\Api\ProfileService::class);

        $this->app->singleton('centrifugo', static fn () => new \phpcent\Client(
            getenv('CENTRIFUGO_API_HOST'),
            getenv('CENTRIFUGO_API_KEY'),
            getenv('CENTRIFUGO_SECRET')
        ));

        // // Services
        // $this->app->bind(RoleServiceInterface::class, RoleService::class);
        // $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
        // $this->app->bind(ProductServiceInterface::class, ProductService::class);

        // // Repositories
        // $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        // $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        // $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    }

    public function boot(): void
    {
        $this->app->singleton(
            AMQPStreamConnection::class,
            static fn (): AMQPStreamConnection => new AMQPStreamConnection(
                getenv('RABBIT_MQ_HOST'),
                getenv('RABBIT_MQ_PORT'),
                getenv('RABBIT_MQ_USERNAME'),
                getenv('RABBIT_MQ_PASSWORD'),
            )
        );
    }

    private function registerBuses(): void
    {
        $this->app->bind(
            DomainEventSubscriberLocator::class,
            static fn (\Illuminate\Contracts\Foundation\Application $app): DomainEventSubscriberLocator => new DomainEventSubscriberLocator($app->tagged('domain_event_subscriber'))
        );

        // $this->app->bind(
        //     EventBusInterface::class,
        //     static fn (\Illuminate\Contracts\Foundation\Application $app): MessengerEventBus => new MessengerEventBus($app->tagged('domain_event_subscriber'))
        // );

        $this->app->bind(EventBusInterface::class, RabbitMQEventBus::class);

        $this->app->bind(
            QueryBusInterface::class,
            static fn (\Illuminate\Contracts\Foundation\Application $app): MessengerQueryBus => new MessengerQueryBus($app->tagged('query_handler'))
        );

        $this->app->bind(
            CommandBusInterface::class,
            static fn (\Illuminate\Contracts\Foundation\Application $app): MessengerCommandBus => new MessengerCommandBus($app->tagged('command_handler'))
        );

        #region RabbitMQ Command Bus
        $this->app->bind(
            CommandHandlerLocator::class,
            static fn (\Illuminate\Contracts\Foundation\Application $app): CommandHandlerLocator => new CommandHandlerLocator($app->tagged('command_handler'))
        );

        // $this->app->bind(CommandBusInterface::class, RabbitMQCommandBus::class);
        #endregion

        #region Doctrine
        // Entities
        $this->app->singleton('admin_doctrine_entity_paths', static fn (): ArrayCollection => new ArrayCollection());

        \Illuminate\Foundation\Application::macro('addAdminEntityPaths', function (array $entityPaths): void {
            $entityPathCollect = $this->make('admin_doctrine_entity_paths');

            foreach ($entityPaths as $entityPath) {
                $entityPathCollect->add($entityPath);
            }
        });

        $this->app->singleton('client_doctrine_entity_paths', static fn (): ArrayCollection => new ArrayCollection());

        \Illuminate\Foundation\Application::macro('addClientEntityPaths', function (array $entityPaths): void {
            $entityPathCollect = $this->make('client_doctrine_entity_paths');

            foreach ($entityPaths as $entityPath) {
                $entityPathCollect->add($entityPath);
            }
        });

        // Migrations
        $this->app->singleton('admin_doctrine_migration_paths', static fn (): array => []);

        \Illuminate\Foundation\Application::macro('addAdminMigrationPaths', function (array $migrationsPaths): void {
            $migrationPathCollection = $this->make('admin_doctrine_migration_paths');
            $this->singleton('admin_doctrine_migration_paths', static fn (): array => array_merge($migrationPathCollection, $migrationsPaths));
        });

        $this->app->singleton('client_doctrine_migration_paths', static fn (): array => []);

        \Illuminate\Foundation\Application::macro('addClientMigrationPaths', function (array $migrationsPaths): void {
            $migrationPathCollection = $this->make('client_doctrine_migration_paths');
            $this->singleton('client_doctrine_migration_paths', static fn (): array => array_merge($migrationPathCollection, $migrationsPaths));
        });
        #endregion

    }
}
