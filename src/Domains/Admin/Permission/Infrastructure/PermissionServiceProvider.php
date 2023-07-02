<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Permission\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Project\Domains\Admin\Permission\Application\Queries\Index\QueryHandler as IndexQueryHandler;
use Project\Domains\Admin\Permission\Domain\PermissionRepositoryInterface;
use Project\Domains\Admin\Permission\Infrastructure\Eloquent\PermissionRepository;

final class PermissionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);

        $this->app->tag(IndexQueryHandler::class, 'query_handler');
    }
}
