<?php

declare(strict_types=1);

namespace Project\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Project\Infrastructure\Services\Authenticate\AuthenticationServiceInterface;
use Project\Shared\Application\AuthorizationInterface;
use Project\Shared\Domain\FlasherInterface;
use Project\Shared\Domain\CodeGeneratorInterface;
use Project\Shared\Domain\FilesystemInterface;
use Project\Shared\Domain\LoggerInterface;
use Project\Shared\Domain\PasswordHasherInterface;
use Project\Shared\Domain\TokenGeneratorInterface;
use Project\Shared\Domain\UuidGeneratorInterface;
use Project\Shared\Infrastructure\Authorization\Authorization;
use Project\Shared\Infrastructure\CodeGenerator;
use Project\Shared\Infrastructure\FileDriver\LaravelFilesystem;
use Project\Shared\Infrastructure\Flasher;
use Project\Shared\Infrastructure\Logger\LaravelLogger;
use Project\Shared\Infrastructure\PasswordHasher;
use Project\Shared\Infrastructure\Services\AuthenticateService\AuthenticationService;
use Project\Shared\Infrastructure\TokenGenerator;
use Project\Shared\Infrastructure\UuidGenerator;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;

final class InfrastructureServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(AuthenticationServiceInterface::class, AuthenticationService::class);
        $this->app->singleton(UuidGeneratorInterface::class, UuidGenerator::class);
        $this->app->singleton(TokenGeneratorInterface::class, TokenGenerator::class);
        $this->app->singleton(CodeGeneratorInterface::class, CodeGenerator::class);
        $this->app->bind(AuthorizationInterface::class, Authorization::class);
        $this->app->singleton(LoggerInterface::class, LaravelLogger::class);
        $this->app->bind(MailerInterface::class, static fn () => new Mailer(Transport::fromDsn(env('MAILER_DSN'))));
        $this->app->bind(FilesystemInterface::class, LaravelFilesystem::class);
        $this->app->singleton(PasswordHasherInterface::class, PasswordHasher::class);
        $this->app->singleton(FlasherInterface::class, Flasher::class);
    }
}
