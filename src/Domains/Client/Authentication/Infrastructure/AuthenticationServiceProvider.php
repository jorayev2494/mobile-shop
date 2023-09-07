<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Infrastructure;

use App\Http\Controllers\Api\Client\Authentication\RegisterController;
use Illuminate\Support\ServiceProvider;
use Project\Domains\Client\Authentication\Application\Commands\Login\CommandHandler as LoginCommandHandler;
use Project\Domains\Client\Authentication\Application\Commands\Register\CommandHandler as RegisterCommandHandler;
use Project\Domains\Client\Authentication\Application\Commands\RestorePasswordCode\CommandHandler as RestoreCodeCommandHandler;
use Project\Domains\Client\Authentication\Application\Commands\RestorePassword\CommandHandler as RestorePasswordCommandHandler;
use Project\Domains\Client\Authentication\Application\Subscribers\ProfileEmailWasUpdatedDomainEventSubscriber;
use Project\Domains\Client\Authentication\Application\Subscribers\RestorePasswordCodeWasCreatedDomainEventSubscriber;
use Project\Domains\Client\Authentication\Domain\Code\CodeRepositoryInterface;
use Project\Domains\Client\Authentication\Domain\Device\DeviceRepositoryInterface;
use Project\Domains\Client\Authentication\Domain\MemberRepositoryInterface;
use Project\Domains\Client\Authentication\Infrastructure\Doctrine\Code\CodeRepository;
use Project\Domains\Client\Authentication\Infrastructure\Doctrine\Device\DeviceRepository;
use Project\Domains\Client\Authentication\Infrastructure\Doctrine\MemberRepository;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Infrastructure\Bus\RabbitMQ\Command\RabbitMQCommandBus;

final class AuthenticationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->when([
            RegisterController::class,
        ])
        ->needs(CommandBusInterface::class)
        ->give(RabbitMQCommandBus::class);

        $this->app->addClientEntityPaths([
            __DIR__ . '/../Domain',
            __DIR__ . '/../Domain/Device',
            __DIR__ . '/../Domain/Code',
        ]);

        $this->app->addClientMigrationPaths([
            'Project\Domains\Client\Authentication\Infrastructure\Doctrine\Migrations' => __DIR__ . '/Doctrine/Migrations',
        ]);

        $this->app->bind(MemberRepositoryInterface::class, MemberRepository::class);
        $this->app->bind(CodeRepositoryInterface::class, CodeRepository::class);
        $this->app->bind(DeviceRepositoryInterface::class, DeviceRepository::class);

        $this->app->tag(RegisterCommandHandler::class, 'command_handler');
        $this->app->tag(LoginCommandHandler::class, 'command_handler');
        // Restore
        $this->app->tag(RestoreCodeCommandHandler::class, 'command_handler');
        $this->app->tag(RestorePasswordCommandHandler::class, 'command_handler');

        $this->app->tag(RestorePasswordCodeWasCreatedDomainEventSubscriber::class, 'domain_event_subscriber');
        $this->app->tag(ProfileEmailWasUpdatedDomainEventSubscriber::class, 'domain_event_subscriber');
    }
}
