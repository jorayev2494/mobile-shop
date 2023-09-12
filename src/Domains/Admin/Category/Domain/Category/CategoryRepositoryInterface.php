<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Category\Domain\Category;

use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Admin\Category\Domain\Category\ValueObjects\CategoryUuid;
use Project\Shared\Application\Query\BaseQuery;

interface CategoryRepositoryInterface
{
    public function get(): array;
    public function paginate(BaseQuery $queryData): Paginator;
    public function findByUuid(CategoryUuid $uuid): ?Category;
    public function save(Category $category): void;
    public function delete(Category $category): void;
}
