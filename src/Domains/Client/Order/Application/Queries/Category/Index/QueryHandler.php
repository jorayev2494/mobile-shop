<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Queries\Category\Index;

use Illuminate\Contracts\Support\Arrayable;
use Project\Domains\Client\Order\Domain\Category\CategoryRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
    )
    {

    }

    public function __invoke(Query $query): array
    {
        return array_map(
            static fn (Arrayable $cat): array => $cat->toArray(),
            $this->categoryRepository->get($query)
        );
    }
}
