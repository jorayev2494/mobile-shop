<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Category\Infrastructure;

use App\Providers\AdminDomainServiceProvider;
use Project\Domains\Admin\Category\Application\Commands\Create\CreateCategoryCommandHandler;
use Project\Domains\Admin\Category\Application\Commands\Delete\DeleteCategoryCommandHandler;
use Project\Domains\Admin\Category\Application\Commands\Update\UpdateCategoryCommandHandler;
use Project\Domains\Admin\Category\Application\Queries\Find\FindCategoryQueryHandler;
use Project\Domains\Admin\Category\Application\Queries\Get\GetCategoriesQueryHandler;
use Project\Domains\Admin\Category\Domain\Category\CategoryRepositoryInterface;
use Project\Domains\Admin\Category\Infrastructure\Doctrine\Category\CategoryRepository;

final class CategoryServiceProvider extends AdminDomainServiceProvider
{
    protected const ENTITY_TYPES = [
        \Project\Domains\Admin\Category\Infrastructure\Doctrine\Category\Types\UuidType::class,
        \Project\Domains\Admin\Category\Infrastructure\Doctrine\Category\Types\ValueType::class,
    ];

    protected const MIGRATION_PATHS = [
        'Project\Domains\Admin\Country\Infrastructure\Doctrine\Migrations' => __DIR__ . '/Doctrine/Migrations',
    ];

    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Category',
    ];

    protected const SERVICES = [
        CategoryRepositoryInterface::class => [self::SERVICE_BIND, CategoryRepository::class],
    ];

    protected const QUERY_HANDLERS = [
        GetCategoriesQueryHandler::class,
        FindCategoryQueryHandler::class,
    ];

    protected const COMMAND_HANDLERS = [
        CreateCategoryCommandHandler::class,
        UpdateCategoryCommandHandler::class,
        DeleteCategoryCommandHandler::class,
    ];
}
