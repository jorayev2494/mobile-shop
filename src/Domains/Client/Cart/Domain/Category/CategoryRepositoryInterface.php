<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Domain\Category;

use Project\Domains\Client\Cart\Domain\Category\ValueObjects\Uuid;

interface CategoryRepositoryInterface
{
    public function findByUuid(Uuid $uuid): ?Category;

    public function save(Category $category): void;

    public function delete(Category $category): void;
}
