<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Project\Domains\Admin\Role\Application\Commands\Create\CreateRoleCommandHandler;
use Project\Domains\Admin\Role\Application\Commands\Delete\DeleteRoleCommandHandler;
use Project\Domains\Admin\Role\Application\Commands\Update\UpdateRoleCommandHandler;
use Project\Domains\Admin\Role\Application\Queries\GetRoles\GetRolesQueryHandler;
use Project\Domains\Admin\Role\Application\Queries\ShowRole\ShowQueryHandler;
use Project\Domains\Admin\Role\Domain\RoleRepositoryInterface;
use Project\Domains\Admin\Role\Infrastructure\Eloquent\RoleRepository;

class RoleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);

        $this->app->tag(CreateRoleCommandHandler::class, 'command_handler');
        $this->app->tag(UpdateRoleCommandHandler::class, 'command_handler');
        $this->app->tag(DeleteRoleCommandHandler::class, 'command_handler');

        $this->app->tag(GetRolesQueryHandler::class, 'query_handler');
        $this->app->tag(ShowQueryHandler::class, 'query_handler');
    }
}
