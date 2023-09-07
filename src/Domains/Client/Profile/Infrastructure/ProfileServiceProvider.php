<?php

declare(strict_types=1);

namespace Project\Domains\Client\Profile\Infrastructure;

use Doctrine\DBAL\Types\Type;
use Illuminate\Support\ServiceProvider;
use Project\Domains\Client\Profile\Application\Commands\Update\CommandHandler as UpdateCommandHandler;
use Project\Domains\Client\Profile\Application\Queries\Show\QueryHandler as ShowQueryHandler;
use Project\Domains\Client\Profile\Application\Subscribers\MemberWasAddedDeviceDomainEventSubscriber;
use Project\Domains\Client\Profile\Application\Subscribers\MemberWasRegisteredDomainEventSubscriber;
use Project\Domains\Client\Profile\Domain\Device\DeviceRepositoryInterface;
use Project\Domains\Client\Profile\Domain\Profile\ProfileRepositoryInterface;
use Project\Domains\Client\Profile\Infrastructure\Doctrine\Device\DeviceRepository;
use Project\Domains\Client\Profile\Infrastructure\Doctrine\Profile\ProfileRepository;
use Project\Domains\Client\Profile\Infrastructure\Doctrine\Profile\Types\EmailType;
use Project\Domains\Client\Profile\Infrastructure\Doctrine\Profile\Types\FirstNameType;
use Project\Domains\Client\Profile\Infrastructure\Doctrine\Profile\Types\LastNameType;
use Project\Domains\Client\Profile\Infrastructure\Doctrine\Profile\Types\PhoneType;

final class ProfileServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Type::addType(FirstNameType::TYPE, FirstNameType::class);
        Type::addType(LastNameType::TYPE, LastNameType::class);
        Type::addType(EmailType::TYPE, EmailType::class);
        Type::addType(PhoneType::TYPE, PhoneType::class);

        $this->app->bind(ProfileRepositoryInterface::class, ProfileRepository::class);
        $this->app->bind(DeviceRepositoryInterface::class, DeviceRepository::class);

        $this->app->addClientEntityPaths([
            __DIR__ . '/../Domain/Device',
            __DIR__ . '/../Domain/Profile',
        ]);

        $this->app->addClientMigrationPaths([
            'Project\Domains\Client\Profile\Infrastructure\Doctrine\Device\Migrations' => __DIR__ . '/Doctrine/Device/Migrations',
            'Project\Domains\Client\Profile\Infrastructure\Doctrine\Profile\Migrations' => __DIR__ . '/Doctrine/Profile/Migrations',
        ]);

        $this->app->tag(UpdateCommandHandler::class, 'command_handler');

        $this->app->tag(ShowQueryHandler::class, 'query_handler');

        $this->app->tag(MemberWasRegisteredDomainEventSubscriber::class, 'domain_event_subscriber');
        $this->app->tag(MemberWasAddedDeviceDomainEventSubscriber::class, 'domain_event_subscriber');
    }
}
