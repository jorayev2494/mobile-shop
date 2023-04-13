<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Project\Domains\Admin\Role\Domain\RoleRepositoryInterface;
use Project\Domains\Admin\Role\Infrastructure\Eloquent\RoleRepository;

class RoleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
    }
}
