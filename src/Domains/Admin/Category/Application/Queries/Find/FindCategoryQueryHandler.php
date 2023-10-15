<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Category\Application\Queries\Find;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Category\Domain\Category\CategoryRepositoryInterface;
use Project\Domains\Admin\Category\Domain\Category\ValueObjects\CategoryUuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

final class FindCategoryQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly CategoryRepositoryInterface $repository,
    )
    {
        
    }

    public function __invoke(FindCategoryQuery $query): object
    {
        $category = $this->repository->findByUuid(CategoryUuid::fromValue($query->uuid));

        if ($category === null) {
            throw new ModelNotFoundException();
        }

        return $category;
    }
}
