<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Infrastructure;

use App\Providers\AdminDomainServiceProvider;
use Project\Domains\Admin\Profile\Domain\Avatar\AvatarRepositoryInterface;
use Project\Domains\Admin\Profile\Domain\Profile\ProfileRepositoryInterface;
use Project\Domains\Admin\Profile\Domain\Profile\Services\AvatarServiceInterface;
use Project\Domains\Admin\Profile\Infrastructure\Doctrine\Avatar\AvatarRepository;
use Project\Domains\Admin\Profile\Infrastructure\Doctrine\Profile\ProfileRepository;
use Project\Domains\Admin\Profile\Infrastructure\Services\AvatarService;

class ProfileServiceProvider extends AdminDomainServiceProvider
{
    protected const SERVICES = [
        ProfileRepositoryInterface::class => [self::SERVICE_BIND, ProfileRepository::class],
        AvatarRepositoryInterface::class => [self::SERVICE_BIND, AvatarRepository::class],
        AvatarServiceInterface::class => [self::SERVICE_SINGLETON, AvatarService::class],
    ];

    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Profile',
        __DIR__ . '/../Domain/Avatar',
    ];

    protected const MIGRATION_PATHS = [
        'Project\Domains\Admin\Profile\Infrastructure\Doctrine\Migrations' => __DIR__ . '/Doctrine/Migrations',
    ];

    protected const ENTITY_TYPES = [
        \Project\Domains\Admin\Profile\Infrastructure\Doctrine\Profile\Types\FirstNameType::class,
        \Project\Domains\Admin\Profile\Infrastructure\Doctrine\Profile\Types\LastNameType::class,
        \Project\Domains\Admin\Profile\Infrastructure\Doctrine\Profile\Types\EmailType::class,
        \Project\Domains\Admin\Profile\Infrastructure\Doctrine\Profile\Types\PhoneType::class,
    ];

    protected const QUERY_HANDLERS = [
        \Project\Domains\Admin\Profile\Application\Queries\GetProfile\QueryHandler::class,
    ];

    protected const COMMAND_HANDLERS = [
        \Project\Domains\Admin\Profile\Application\Commands\Update\CommandHandler::class,
        \Project\Domains\Admin\Profile\Application\Commands\ChangePassword\CommandHandler::class,
    ];

    protected const DOMAIN_EVENT_SUBSCRIBERS = [
        \Project\Domains\Admin\Profile\Application\Subscribers\MemberWasRegisteredDomainEventSubscriber::class,
        \Project\Domains\Admin\Profile\Application\Subscribers\Manager\ManagerRoleWasChangedDomainEventSubscriber::class,
        \Project\Domains\Admin\Profile\Application\Subscribers\ProfileAvatarWasDeletedDomainEventSubscriber::class,
    ];
}
