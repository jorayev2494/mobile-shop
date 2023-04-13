<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Admin\Category\Domain;

use App\Repositories\Contracts\BaseModelRepositoryInterface;
use Project\Domains\Category\Domain\ValueObjects\CategoryUUID;

interface CategoryRepositoryInterface extends BaseModelRepositoryInterface
{
    public function save(Category $category): bool;
    public function delete(CategoryUUID $uuid): void;
}