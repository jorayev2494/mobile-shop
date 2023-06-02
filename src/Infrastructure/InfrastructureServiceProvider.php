<?php

declare(strict_types=1);

namespace Project\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Project\Shared\Domain\LoggerInterface;
use Project\Shared\Domain\MailerInterface;
use Project\Shared\Domain\UuidGeneratorInterface;
use Project\Shared\Infrastructure\Logger\LaravelLogger;
use Project\Shared\Infrastructure\Mailer\LaravelMailer;
use Project\Shared\Infrastructure\UuidGenerator;

final class InfrastructureServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UuidGeneratorInterface::class, UuidGenerator::class);
        $this->app->bind(LoggerInterface::class, LaravelLogger::class);
        $this->app->bind(MailerInterface::class, LaravelMailer::class);
    }
}
