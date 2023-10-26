<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Queries\Find;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Product\Domain\Product\Product;
use Project\Domains\Admin\Product\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductUuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;
use Project\Shared\Domain\DomainException;

final class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        public readonly ProductRepositoryInterface $repository,
    ) {

    }

    /**
     * @throws ModelNotFoundException
     */
    public function __invoke(Query $query): Product
    {
        $product = $this->repository->findByUuid(ProductUuid::fromValue($query->uuid));

        if ($product === null) {
            throw new DomainException('Product not found', 404);
        }

        return $product;
    }
}
