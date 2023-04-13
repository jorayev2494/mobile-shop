<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Category\Application\Queries\Find;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Category\Domain\CategoryRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandler;

final class FindCategoryQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly CategoryRepositoryInterface $repository,
    )
    {
        
    }

    public function __invoke(FindCategoryQuery $query): object
    {
        $model = $this->repository->findOrNull($query->uuid);

        if ($model === null) {
            throw new ModelNotFoundException();
        }

        return $model;
    }
}
