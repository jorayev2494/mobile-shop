<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Queries\Find;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Product\Domain\Product\Product;
use Project\Domains\Admin\Product\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductUuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

final class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        public readonly ProductRepositoryInterface $repository,
    )
    {

    }

    /**
     * @throws ModelNotFoundException
     */
    public function __invoke(Query $query): Product
    {
        $product = $this->repository->findByUuid(ProductUuid::fromValue($query->uuid));

        if ($product === null) {
            throw new ModelNotFoundException();
        }

        return $product;
    }
}
