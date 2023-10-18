<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Domain\Category;

use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Admin\Product\Domain\Category\ValueObjects\Uuid;
use Project\Shared\Application\Query\BaseQuery;

interface CategoryRepositoryInterface
{
    public function get(): array;

    public function paginate(BaseQuery $queryData): Paginator;

    public function findByUuid(Uuid $uuid): ?Category;

    public function save(Category $category): void;

    public function delete(Category $category): void;
}
