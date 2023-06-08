<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Category\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Project\Domains\Admin\Category\Application\Commands\Create\CreateCategoryCommandHandler;
use Project\Domains\Admin\Category\Application\Commands\Delete\DeleteCategoryCommandHandler;
use Project\Domains\Admin\Category\Application\Commands\Update\UpdateCategoryCommandHandler;
use Project\Domains\Admin\Category\Application\Queries\Find\FindCategoryQueryHandler;
use Project\Domains\Admin\Category\Application\Queries\Get\GetCategoriesQueryHandler;
use Project\Domains\Admin\Category\Domain\CategoryRepositoryInterface;
use Project\Domains\Admin\Category\Infrastructure\Eloquent\CategoryRepository;

final class CategoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);

        $this->app->tag(GetCategoriesQueryHandler::class, 'query_handler');
        $this->app->tag(FindCategoryQueryHandler::class, 'query_handler');

        $this->app->tag(CreateCategoryCommandHandler::class, 'command_handler');
        $this->app->tag(UpdateCategoryCommandHandler::class, 'command_handler');
        $this->app->tag(DeleteCategoryCommandHandler::class, 'command_handler');
    }
}
