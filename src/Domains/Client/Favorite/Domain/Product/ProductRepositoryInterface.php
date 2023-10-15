<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Domain\Product;

use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Client\Favorite\Domain\Member\ValueObjects\MemberUuid;
use Project\Domains\Client\Favorite\Domain\Product\ValueObjects\ProductUuid;
use Project\Shared\Application\Query\BaseQuery;

interface ProductRepositoryInterface
{
    public function findByUuid(ProductUuid $uuid): ?Product;
    public function memberFavoriteProducts(MemberUuid $uuid, BaseQuery $queryData): Paginator;
    public function save(Product $product): void;
    public function delete(Product $product): void;
}
