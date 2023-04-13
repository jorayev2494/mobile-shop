<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Category\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Project\Domains\Admin\Category\Domain\CategoryRepositoryInterface;
use Project\Domains\Admin\Category\Infrastructure\Eloquent\CategoryRepository;

final class CategoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
    }
}
