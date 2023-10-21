<?php

declare(strict_types=1);

namespace Project\Domains\Client\Profile\Infrastructure;

use App\Providers\ClientDomainServiceProvider;
use Project\Domains\Client\Profile\Domain\Device\DeviceRepositoryInterface;
use Project\Domains\Client\Profile\Domain\Profile\ProfileRepositoryInterface;
use Project\Domains\Client\Profile\Infrastructure\Doctrine\Device\DeviceRepository;
use Project\Domains\Client\Profile\Infrastructure\Doctrine\Profile\ProfileRepository;

final class ProfileServiceProvider extends ClientDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        ProfileRepositoryInterface::class => [self::SERVICE_BIND, ProfileRepository::class],
        DeviceRepositoryInterface::class => [self::SERVICE_BIND, DeviceRepository::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        \Project\Domains\Client\Profile\Application\Queries\Show\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        \Project\Domains\Client\Profile\Application\Commands\Update\CommandHandler::class,
        \Project\Domains\Client\Profile\Application\Commands\Create\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [
        \Project\Domains\Client\Profile\Application\Subscribers\MemberWasAddedDeviceDomainEventSubscriber::class,
        \Project\Domains\Client\Profile\Application\Subscribers\MemberWasRegisteredDomainEventSubscriber::class,
    ];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        \Project\Domains\Client\Profile\Infrastructure\Doctrine\Profile\Types\EmailType::class,
        \Project\Domains\Client\Profile\Infrastructure\Doctrine\Profile\Types\FirstNameType::class,
        \Project\Domains\Client\Profile\Infrastructure\Doctrine\Profile\Types\LastNameType::class,
        \Project\Domains\Client\Profile\Infrastructure\Doctrine\Profile\Types\PhoneType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        'Project\Domains\Client\Profile\Infrastructure\Doctrine\Device\Migrations' => __DIR__ . '/Doctrine/Device/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Device',
        __DIR__ . '/../Domain/Profile',
    ];
}
