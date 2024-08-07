<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Category\Infrastructure\Eloquent;

use App\Models\Category as CategoryModel;
use App\Repositories\Base\BaseModelRepository;
use Project\Domains\Admin\Category\Domain\Category\Category;
use Project\Domains\Admin\Category\Domain\Category\CategoryRepositoryInterface;
use Project\Domains\Admin\Category\Domain\Category\ValueObjects\CategoryUuid;

final class CategoryRepository extends BaseModelRepository // implements CategoryRepositoryInterface
{

    public function getModel(): string
    {
        return CategoryModel::class;
    }

    public function save(Category $category): bool
    {
        return (bool) $this->getModelClone()->newQuery()->updateOrCreate(
            [
                // 'uuid' => $category->uuid->value,
            ],
            $category->toArray()
        );
    }

    public function delete(CategoryUuid $uuid): void
    {
        $this->getModelClone()->newQuery()->find($uuid->value)->delete();
    }
}
