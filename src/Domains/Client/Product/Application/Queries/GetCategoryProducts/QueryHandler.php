<?php

declare(strict_types=1);

namespace Project\Domains\Client\Product\Application\Queries\GetCategoryProducts;

use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductCategoryUuid;
use Project\Domains\Client\Product\Domain\ProductRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
    )
    {

    }

    public function __invoke(Query $query): Paginator
    {
        return $this->productRepository->getProductsByCategoryUuid(
            $query,
            ProductCategoryUuid::fromValue($query->categoryUuid)
        );
    }
}
