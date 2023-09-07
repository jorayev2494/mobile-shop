<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Infrastructure;

use Doctrine\DBAL\Types\Type;
use Illuminate\Support\ServiceProvider;
use Project\Domains\Admin\Role\Application\Commands\Create\CommandHandler as CreateRoleCommandHandler;
use Project\Domains\Admin\Role\Application\Commands\CreatePermission\CommandHandler as CreatePermissionCommandHandler;
use Project\Domains\Admin\Role\Application\Commands\Delete\CommandHandler as DeleteRoleCommandHandler;
use Project\Domains\Admin\Role\Application\Commands\Update\CommandHandler as UpdateRoleCommandHandler;
use Project\Domains\Admin\Role\Application\Queries\GetPermissions\QueryHandler as GetPermissionsQueryHandler;
use Project\Domains\Admin\Role\Application\Queries\GetRoles\QueryHandler as GetRolesQueryHandler;
use Project\Domains\Admin\Role\Application\Queries\ShowRole\QueryHandler as ShowQueryHandler;
use Project\Domains\Admin\Role\Domain\RoleRepositoryInterface;
use Project\Domains\Admin\Role\Infrastructure\Doctrine\Permission\PermissionRepository;
use Project\Domains\Admin\Role\Infrastructure\Doctrine\Permission\Types\IdType as PermissionIdType;
use Project\Domains\Admin\Role\Infrastructure\Doctrine\Permission\Types\ValueType as PermissionValueType;
use Project\Domains\Admin\Role\Infrastructure\Doctrine\Permission\Types\SubjectType as PermissionSubjectType;
use Project\Domains\Admin\Role\Infrastructure\Doctrine\Permission\Types\ActionType as PermissionActionType;
use Project\Domains\Admin\Role\Infrastructure\Doctrine\RoleRepository;
use Project\Domains\Admin\Role\Infrastructure\Doctrine\Types\ValueType;
use Project\Domains\Admin\Role\Domain\Permission\PermissionRepositoryInterface;

class RoleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->addAdminEntityPaths([
            __DIR__ . '/../Domain',
            __DIR__ . '/../Domain/Permission',
        ]);

        $this->app->addAdminMigrationPaths([
            'Project\Domains\Admin\Role\Infrastructure\Doctrine\Migrations' => __DIR__ . '/Doctrine/Migrations',
            'Project\Domains\Admin\Role\Infrastructure\Doctrine\Permission\Migrations' => __DIR__ . '/Doctrine/Permission/Migrations',
        ]);

        // Role
        Type::addType(ValueType::NAME, ValueType::class);

        // Permission
        Type::addType(PermissionIdType::NAME, PermissionIdType::class);
        Type::addType(PermissionValueType::NAME, PermissionValueType::class);
        Type::addType(PermissionSubjectType::NAME, PermissionSubjectType::class);
        Type::addType(PermissionActionType::NAME, PermissionActionType::class);

        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);

        $this->app->tag(GetRolesQueryHandler::class, 'query_handler');
        $this->app->tag(ShowQueryHandler::class, 'query_handler');
        $this->app->tag(GetPermissionsQueryHandler::class, 'query_handler');

        $this->app->tag(CreateRoleCommandHandler::class, 'command_handler');
        $this->app->tag(UpdateRoleCommandHandler::class, 'command_handler');
        $this->app->tag(DeleteRoleCommandHandler::class, 'command_handler');
        $this->app->tag(CreatePermissionCommandHandler::class, 'command_handler');
    }
}
