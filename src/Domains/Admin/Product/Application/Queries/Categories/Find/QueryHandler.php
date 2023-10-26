<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Queries\Categories\Find;

use Project\Domains\Admin\Product\Domain\Category\CategoryRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Category\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;
use Project\Shared\Domain\DomainException;

final class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly CategoryRepositoryInterface $repository,
    ) {

    }

    public function __invoke(Query $query): object
    {
        $category = $this->repository->findByUuid(Uuid::fromValue($query->uuid));

        if ($category === null) {
            throw new DomainException('Category not found', 404);
        }

        return $category;
    }
}
