<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure;

use App\Providers\AdminDomainServiceProvider;
use Project\Domains\Admin\Authentication\Domain\Code\CodeRepositoryInterface;
use Project\Domains\Admin\Authentication\Domain\Device\DeviceRepositoryInterface;
use Project\Domains\Admin\Authentication\Domain\Member\MemberRepositoryInterface;
use Project\Domains\Admin\Authentication\Infrastructure\Doctrine\Code\CodeRepository;
use Project\Domains\Admin\Authentication\Infrastructure\Doctrine\Device\DeviceRepository;
use Project\Domains\Admin\Authentication\Infrastructure\Doctrine\MemberRepository;
use Project\Domains\Admin\Authentication\Domain\Role\RoleRepositoryInterface;
use Project\Domains\Admin\Authentication\Infrastructure\Doctrine\Role\RoleRepository;
use Project\Domains\Admin\Authentication\Domain\Permission\PermissionRepositoryInterface;
use Project\Domains\Admin\Authentication\Infrastructure\Doctrine\Permission\PermissionRepository;

final class AuthenticationServiceProvider extends AdminDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        MemberRepositoryInterface::class => [self::SERVICE_BIND, MemberRepository::class],
        DeviceRepositoryInterface::class => [self::SERVICE_BIND, DeviceRepository::class],
        CodeRepositoryInterface::class => [self::SERVICE_BIND, CodeRepository::class],

        RoleRepositoryInterface::class => [self::SERVICE_BIND, RoleRepository::class],
        PermissionRepositoryInterface::class => [self::SERVICE_BIND, PermissionRepository::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        // Role
        \Project\Domains\Admin\Authentication\Application\Queries\Roles\GetRoles\QueryHandler::class,
        \Project\Domains\Admin\Authentication\Application\Queries\Roles\ShowRole\QueryHandler::class,
        \Project\Domains\Admin\Authentication\Application\Queries\Roles\GetPermissions\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        // Authentication
        \Project\Domains\Admin\Authentication\Application\Commands\Register\CommandHandler::class,
        \Project\Domains\Admin\Authentication\Application\Commands\Login\CommandHandler::class,
        \Project\Domains\Admin\Authentication\Application\Commands\RefreshToken\CommandHandler::class,
        \Project\Domains\Admin\Authentication\Application\Commands\RestorePassword\CommandHandler::class,
        \Project\Domains\Admin\Authentication\Application\Commands\RestorePasswordLink\CommandHandler::class,

        // Role
        \Project\Domains\Admin\Authentication\Application\Commands\Roles\Create\CommandHandler::class,
        \Project\Domains\Admin\Authentication\Application\Commands\Roles\CreatePermission\CommandHandler::class,
        \Project\Domains\Admin\Authentication\Application\Commands\Roles\Delete\CommandHandler::class,
        \Project\Domains\Admin\Authentication\Application\Commands\Roles\Update\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [
        // Authentication
        \Project\Domains\Admin\Authentication\Application\Subscribers\MemberRestorePasswordLinkWasAddedDomainEventSubscriber::class,

        // Role
        \Project\Domains\Admin\Authentication\Application\Subscribers\MemberRestorePasswordLinkWasAddedDomainEventSubscriber::class,
        \Project\Domains\Admin\Authentication\Application\Subscribers\ManagerRoleWasChangedDomainEventSubscriber::class,
    ];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        // Authentication

        // Role
        \Project\Domains\Admin\Authentication\Infrastructure\Doctrine\Role\Types\ValueType::class,

        // Permission
        \Project\Domains\Admin\Authentication\Infrastructure\Doctrine\Permission\Types\IdType::class,
        \Project\Domains\Admin\Authentication\Infrastructure\Doctrine\Permission\Types\SubjectType::class,
        \Project\Domains\Admin\Authentication\Infrastructure\Doctrine\Permission\Types\TypeType::class,
        \Project\Domains\Admin\Authentication\Infrastructure\Doctrine\Permission\Types\ValueType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        'Project\Domains\Admin\Authentication\Infrastructure\Doctrine\Migrations' => __DIR__ . '/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Member',
        __DIR__ . '/../Domain/Device',
        __DIR__ . '/../Domain/Code',
        __DIR__ . '/../Domain/Role',
        __DIR__ . '/../Domain/Permission',
    ];
}
