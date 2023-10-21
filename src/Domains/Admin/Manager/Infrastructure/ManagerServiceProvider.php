<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Infrastructure;

use App\Providers\AdminDomainServiceProvider;
use Project\Domains\Admin\Manager\Domain\Avatar\AvatarRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Infrastructure\Doctrine\Avatar\AvatarRepository;
use Project\Domains\Admin\Manager\Infrastructure\Doctrine\Manager\ManagerRepository;

class ManagerServiceProvider extends AdminDomainServiceProvider
{
    protected const SERVICES = [
        ManagerRepositoryInterface::class => [self::SERVICE_BIND, ManagerRepository::class],
        AvatarRepositoryInterface::class => [self::SERVICE_BIND, AvatarRepository::class],
    ];

    protected const QUERY_HANDLERS = [
        // Manager
        \Project\Domains\Admin\Manager\Application\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\Manager\Application\Queries\Show\QueryHandler::class,
    ];

    protected const COMMAND_HANDLERS = [
        // Manager
        \Project\Domains\Admin\Manager\Application\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\Manager\Application\Commands\Update\CommandHandler::class,
        \Project\Domains\Admin\Manager\Application\Commands\Delete\CommandHandler::class,
    ];

    protected const DOMAIN_EVENT_SUBSCRIBERS = [
        \Project\Domains\Admin\Manager\Application\Subscribers\MemberWasRegisteredDomainEventSubscriber::class,
        \Project\Domains\Admin\Manager\Application\Subscribers\Profile\ProfileFirstNameWasChangedDomainEventSubscriber::class,
        \Project\Domains\Admin\Manager\Application\Subscribers\Profile\ProfileLastNameWasChangedDomainEventSubscriber::class,
        \Project\Domains\Admin\Manager\Application\Subscribers\Profile\ProfileEmailWasChangedDomainEventSubscriber::class,
        \Project\Domains\Admin\Manager\Application\Subscribers\Profile\ProfilePhoneWasChangedDomainEventSubscriber::class,
        \Project\Domains\Admin\Manager\Application\Subscribers\Profile\ProfileAvatarWasChangedDomainEventSubscriber::class,
        \Project\Domains\Admin\Manager\Application\Subscribers\Profile\ProfileAvatarWasDeletedDomainEventSubscriber::class,
    ];

    protected const ENTITY_TYPES = [
        // Manager
        \Project\Domains\Admin\Manager\Infrastructure\Doctrine\Manager\Types\UuidType::class,
        \Project\Domains\Admin\Manager\Infrastructure\Doctrine\Manager\Types\FirstNameType::class,
        \Project\Domains\Admin\Manager\Infrastructure\Doctrine\Manager\Types\LastNameType::class,
        \Project\Domains\Admin\Manager\Infrastructure\Doctrine\Manager\Types\EmailType::class,
        \Project\Domains\Admin\Manager\Infrastructure\Doctrine\Manager\Types\PhoneType::class,
    ];

    protected const MIGRATION_PATHS = [
        'Project\Domains\Admin\Country\Infrastructure\Doctrine\Migrations' => __DIR__ . '/Doctrine/Migrations',
    ];

    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Manager',
        __DIR__ . '/../Domain/Avatar',
    ];
}
