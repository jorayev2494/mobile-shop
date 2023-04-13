<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Queries\Find;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Product\Application\Queries\Find\FindProductQuery;
use Project\Domains\Admin\Product\Domain\ProductRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandler;

final class FindProductQueryHandler implements QueryHandler
{
    public function __construct(
        public readonly ProductRepositoryInterface $repository,
    )
    {

    }

    /**
     * @throws ModelNotFoundException
     */
    public function __invoke(FindProductQuery $query): object
    {
        $product = $this->repository->findOrNull($query->uuid);

        if ($product === null) {
            throw new ModelNotFoundException();
        }

        return $product;
    }
}
