<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Base\BaseModelRepository;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryRepository extends BaseModelRepository implements CategoryRepositoryInterface
{
    public function getModel(): string
    {
        return Category::class;
    }
}
