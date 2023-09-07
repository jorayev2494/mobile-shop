<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Project\Domains\Admin\Authentication\Application\Commands\Register\CommandHandler as RegisterCommandHandler;
use Project\Domains\Admin\Authentication\Application\Commands\Login\CommandHandler as LoginCommandHandler;
use Project\Domains\Admin\Authentication\Application\Commands\RefreshToken\CommandHandler as RefreshTokenCommandHandler;
use Project\Domains\Admin\Authentication\Application\Commands\RestorePassword\CommandHandler as RestorePasswordCommandHandler;
use Project\Domains\Admin\Authentication\Application\Commands\RestorePasswordLink\CommandHandler as RestorePasswordLinkCommandHandler;
use Project\Domains\Admin\Authentication\Application\Subscribers\MemberRestorePasswordLinkWasAddedDomainEventSubscriber;
use Project\Domains\Admin\Authentication\Domain\Code\CodeRepositoryInterface;
use Project\Domains\Admin\Authentication\Domain\Device\DeviceRepositoryInterface;
use Project\Domains\Admin\Authentication\Domain\Member\MemberRepositoryInterface;
use Project\Domains\Admin\Authentication\Infrastructure\Doctrine\Code\CodeRepository;
use Project\Domains\Admin\Authentication\Infrastructure\Doctrine\Device\DeviceRepository;
use Project\Domains\Admin\Authentication\Infrastructure\Doctrine\MemberRepository;

final class AuthenticationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->addAdminEntityPaths([
            __DIR__ . '/../Domain/Member',
            __DIR__ . '/../Domain/Device',
            __DIR__ . '/../Domain/Code',
        ]);

        $this->app->addAdminMigrationPaths([
            'Project\Domains\Admin\Authentication\Infrastructure\Doctrine\Migrations' => __DIR__ . '/Doctrine/Migrations',
            // 'Project\Domains\Admin\Authentication\Infrastructure\Doctrine\Migrations' => __DIR__ . '/Doctrine/Migrations',
            // 'Project\Domains\Admin\Authentication\Infrastructure\Doctrine\Migrations' => __DIR__ . '/Doctrine/Migrations',
        ]);

        $this->app->bind(MemberRepositoryInterface::class, MemberRepository::class);
        $this->app->bind(DeviceRepositoryInterface::class, DeviceRepository::class);
        $this->app->bind(CodeRepositoryInterface::class, CodeRepository::class);

        $this->app->tag(RegisterCommandHandler::class, 'command_handler');
        $this->app->tag(LoginCommandHandler::class, 'command_handler');
        $this->app->tag(RefreshTokenCommandHandler::class, 'command_handler');
        $this->app->tag(RestorePasswordLinkCommandHandler::class, 'command_handler');
        $this->app->tag(RestorePasswordCommandHandler::class, 'command_handler');

        $this->app->tag(MemberRestorePasswordLinkWasAddedDomainEventSubscriber::class, 'domain_event_subscriber');
    }
}
