<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Infrastructure;

use App\Providers\AdminDomainServiceProvider;
use Project\Domains\Admin\Profile\Domain\Profile\ProfileRepositoryInterface;
use Project\Domains\Admin\Profile\Infrastructure\Doctrine\Profile\ProfileRepository;

class ProfileServiceProvider extends AdminDomainServiceProvider
{
    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Profile',
    ];

    protected const MIGRATION_PATHS = [
        'Project\Domains\Admin\Profile\Infrastructure\Doctrine\Profile\Migrations' => __DIR__ . '/Doctrine/Profile/Migrations',
    ];

    protected const ENTITY_TYPES = [
        \Project\Domains\Admin\Profile\Infrastructure\Doctrine\Profile\Types\FirstNameType::class,
        \Project\Domains\Admin\Profile\Infrastructure\Doctrine\Profile\Types\LastNameType::class,
        \Project\Domains\Admin\Profile\Infrastructure\Doctrine\Profile\Types\EmailType::class,
        \Project\Domains\Admin\Profile\Infrastructure\Doctrine\Profile\Types\AvatarType::class,
        \Project\Domains\Admin\Profile\Infrastructure\Doctrine\Profile\Types\PhoneType::class,
    ];

    protected const SERVICES = [
        ProfileRepositoryInterface::class => [self::SERVICE_BIND, ProfileRepository::class],
    ];

    protected const QUERY_HANDLERS = [
        \Project\Domains\Admin\Profile\Application\Queries\GetProfile\QueryHandler::class,
    ];
    
    protected const COMMAND_HANDLERS = [
        \Project\Domains\Admin\Profile\Application\Commands\Update\CommandHandler::class,
        \Project\Domains\Admin\Profile\Application\Commands\ChangePassword\CommandHandler::class,
    ];

    protected const DOMAIN_EVENT_SUBSCRIBERS = [
        \Project\Domains\Admin\Profile\Application\Subscribers\MemberWasRegisteredDomainEventSubscriber::class
    ];
}
