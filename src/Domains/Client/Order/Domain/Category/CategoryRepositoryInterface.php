<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Domain\Category;

use Project\Domains\Client\Order\Domain\Category\ValueObjects\Uuid;
use Project\Shared\Application\Query\BaseQuery;

interface CategoryRepositoryInterface
{
    public function get(BaseQuery $baseQuery): array;

    public function findByUuid(Uuid $uuid): ?Category;

    public function save(Category $category): void;

    public function delete(Category $category): void;
}
