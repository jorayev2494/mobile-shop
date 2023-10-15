<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Category\Application\Queries\Get;

use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Admin\Category\Domain\Category\CategoryRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

final class GetCategoriesQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly CategoryRepositoryInterface $repository
    )
    {
        
    }

    public function __invoke(GetCategoriesQuery $query): Paginator
    {
        return $this->repository->paginate($query);
    }
}
