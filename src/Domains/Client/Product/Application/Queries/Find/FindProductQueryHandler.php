<?php

declare(strict_types=1);

namespace Project\Domains\Client\Product\Application\Queries\Find;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Client\Product\Domain\ProductRepositoryInterface;
use Project\Domains\Client\Product\Domain\ValueObjects\ProductUUID;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

final class FindProductQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository
    )
    {
        
    }

    public function __invoke(FindProductQuery $query): object
    {
        $product = $this->repository->findByUUID(ProductUUID::fromValue($query->uuid));

        if ($product === null) {
            throw new ModelNotFoundException();
        }

        return $product;
    }
}
